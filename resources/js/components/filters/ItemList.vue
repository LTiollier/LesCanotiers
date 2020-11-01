<template>
    <div>
        <v-row align="center" justify="space-between" no-gutters class="mb-3">
            <v-col class="text-left">
                <v-btn
                    v-if="withFilters"
                    dusk="filters-button"
                    class="primary d-inline"
                    @click="filterBar = !filterBar">
                    <v-icon>mdi-filter</v-icon>&nbsp;
                    Filtres
                </v-btn>
                <v-form
                    v-if="withExport"
                    class="d-inline"
                    :action="route('filters.export')"
                    method="post"
                    @submit="prepareExportValues">
                    <csrf-token />
                    <input
                        v-for="(value, key) in exportValues"
                        :key="key"
                        type="hidden"
                        :name="value.key"
                        :value="value.value">
                    <v-btn dusk="export-button" class="secondary" type="submit">
                        <v-icon>mdi-file-download</v-icon>&nbsp;
                        Exporter
                    </v-btn>
                </v-form>
            </v-col>
            <v-col class="text-right" md="auto">
                <slot name="right-button-bar" />
                <inertia-link v-if="createRoute" :href="route(createRoute)">
                    <v-btn
                        dusk="add-resource"
                        class="white--text primary">
                        <v-icon>mdi-add</v-icon>&nbsp;
                        <template v-if="createText">
                            {{ createText }}
                        </template>
                        <template v-else>
                            Ajouter
                        </template>
                    </v-btn>
                </inertia-link>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col
                v-if="withFilters && filterBar"
                dusk="filter_bar"
                cols="12"
                sm="6"
                md="3">
                <filter-bar
                    :save-filter-loading="saveFilterLoading"
                    :delete-filter-loading="deleteFilterLoading"
                    :filters="usableFilters"
                    :stored-filters="storedFilters"
                    @storedFilterSelected="queryFromSelectedFilter"
                    @storedFilterDeleted="deleteStoredFilter"
                    @filterCreated="storeNewFilter"
                    @change="query()"
                    @filterReset="resetFilter"
                    @close="filterBar = false" />
            </v-col>
            <v-col cols="12" :sm="tableSm" :md="tableMd">
                <table-filterable
                    :with-delete="withDelete"
                    :item-route-name="options.itemRouteName"
                    :item-type="options.itemType"
                    :item-key="options.itemKey"
                    :items="items"
                    :total-items="totalItems"
                    :filters="usableFilters"
                    :loading="loading"
                    :paginate-options="paginateOptions"
                    @paginate="query"
                    @delete="$emit('delete', $event)" />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import TableFilterable from './TableFilterable';
import FilterBar from './FilterBar';
import { cloneDeep, findIndex, forEach, isEmpty, find, map } from 'lodash';
import { getFilters, deleteFilter, storeFilter, getModelFiltered } from "../../api/filterService";
import CsrfToken from "../CsrfToken";

export default {
    name: "ItemList",
    components: {
        CsrfToken,
        TableFilterable,
        FilterBar,
    },
    props: {
        filters: {
            type: Array,
            required: false,
            default: null
        },
        withFilters: {
            type: Boolean,
            required: false,
            default: false,
        },
        withExport: {
            type: Boolean,
            required: false,
            default: false,
        },
        createRoute: {
            type: String,
            required: false,
            default: null,
        },
        createText: {
            type: String,
            required: false,
            default: null,
        },
        options: {
            type: Object,
            required: true,
        },
        withDelete: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            items: [],
            totalItems: 0,
            filterBar: false,
            saveFilterLoading: false,
            deleteFilterLoading: false,
            loading: false,
            usableFilters: [],
            paginateOptions: {
                itemsPerPage: 10,
                descending: true,
                page: 1,
            },
            exportValues: {},
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            storedFilters: [],
            storedFiltersDeletionDialog: false,
        }
    },
    computed: {
        localStorageName() {
            return 'filters-' + this.options.pageName;
        },
        tableSm() {
            return this.filterBar && this.withFilters ? 6 : null
        },
        tableMd() {
            return this.filterBar && this.withFilters ? 9 : null
        }
    },
    watch: {
        'options.queryParamsOverride': function(options) {
            this.query(this.paginateOptions);
        },
    },
    mounted() {
        this.usableFilters = cloneDeep(this.filters);
        if(this.withFilters) {
            this.setFiltersDefaultValues();
            this.loadFromLocalStorage();
            this.getStoredFilters();
        }
        if (this.options.columnsOverride) {
            this.filterUserableFiltersActivesColumns();
        }
        if(this.options.defaultDescending !== undefined) {
            this.paginateOptions.descending = this.options.defaultDescending;
        }
    },
    methods: {
        setFiltersDefaultValues() {
            forEach(this.usableFilters, (filter, key) => {
                this.$set(this.usableFilters[key], 'value', this.getFilterDefaultValue(this.usableFilters[key]));
            });
        },
        filterUserableFiltersActivesColumns() {
            this.$set(this, 'usableFilters', map(this.usableFilters, (values) => {
                values.active = this.options.columnsOverride.indexOf(values.name) !== -1;
                return values;
            }));
        },
        resetFilter(filterName) {
            const key = findIndex(this.usableFilters, (usableFilter) => { return usableFilter.name === filterName});
            this.$set(this.usableFilters[key], 'value', this.getFilterDefaultValue(this.usableFilters[key]));
            this.query();
        },
        getFilterDefaultValue(filter) {
            if (this.isTextFilter(filter)) {
                return { strategy: 'contains', term: '' };
            }
            else if (this.isSelectFilter(filter)) {
                return { term: '' };
            }
            else if (this.isCheckboxFilter(filter)) {
                return [];
            }
            else if (this.isDateFilter(filter)) {
                return { strategy: 'equals', date: '', second_date: '' }
            }
            else if (this.isNumberFilter(filter)) {
                return { strategy: 'equals', term: '', second_term: '' }
            }
        },
        isFilterSearchValid(filter) {
            if (this.isTextFilter(filter)) {
                return this.validateTextFilter(filter.value);
            }
            else if (this.isSelectFilter(filter)) {
                return this.validateSelectFilter(filter.value);
            }
            else if (this.isCheckboxFilter(filter)) {
                return this.validateCheckboxFilter(filter.value);
            }
            else if (this.isDateFilter(filter)) {
                return this.validateDateFilter(filter.value);
            }
            else if (this.isNumberFilter(filter)) {
                return this.validateNumberFilter(filter.value);
            }
        },
        isTextFilter(filter) {
            return filter.field.type === 'text';
        },
        isSelectFilter(filter) {
            return filter.field.type === 'select';
        },
        isCheckboxFilter(filter) {
            return filter.field.type === 'checkbox';
        },
        isDateFilter(filter) {
            return filter.field.type === 'date' || filter.field.type === 'datetime';
        },
        isNumberFilter(filter) {
            return filter.field.type === 'number';
        },
        validateTextFilter(value) {
            return !isEmpty(value.strategy) && !isEmpty(value.term);
        },
        validateSelectFilter(value) {
            return !isEmpty(value.term);
        },
        validateCheckboxFilter(value) {
            return !isEmpty(value);
        },
        validateDateFilter(value) {
            return (value.strategy === 'equals' && value.date) ||
                (value.strategy === 'between' && value.date && value.second_date) ||
                ['current_month', 'current_week', 'past_month', 'past_week'].indexOf(value.strategy) !== -1;
        },
        validateNumberFilter(value) {
            return (value.strategy !== 'between' && value.term) ||
                (value.strategy === 'between' && value.term && value.second_term);
        },
        queryFromSelectedFilter(filterId) {
            if (!filterId) {
                this.$set(this, 'usableFilters', cloneDeep(this.filters));
                this.setFiltersDefaultValues();
                this.query();
                return;
            }

            const storedFilterSelected = find(this.storedFilters, storedFilter => storedFilter.id === filterId);
            const columnsToKeep = map(storedFilterSelected.fields, 'name');

            forEach(this.usableFilters, (filter, key) => {
                if (columnsToKeep.indexOf(filter.name) !== -1) {
                    this.$set(this.usableFilters[key], 'active', true);
                    const search = find(storedFilterSelected.fields, field => field.name === filter.name).content;
                    if (!isEmpty(search)) {
                        this.$set(this.usableFilters[key], 'value', search);
                    }
                } else {
                    this.$set(this.usableFilters[key], 'active', false);
                }
            });

            this.query();
        },
        updateLocalStorage(paginateParams) {
            localStorage.setItem(this.localStorageName, JSON.stringify({
                pagination: paginateParams ? paginateParams.itemsPerPage : this.paginateOptions.itemsPerPage,
                filters: this.usableFilters
            }));
        },
        query(paginateParams) {
            let preparedQuery = this.prepareQuery(paginateParams);
            let promise = this.options.routeParams
                ? getModelFiltered(this.options.routeParams, preparedQuery)
                : getModelFiltered(preparedQuery);
            promise.then(response => this.handleQuerySuccess(response.data))
                .catch(error => this.handleQueryError(error));
        },
        prepareQuery(paginateParams) {
            this.loading = true;
            this.paginateOptions = paginateParams ? paginateParams : this.paginateOptions;
            this.paginateOptions.descending = Number(this.paginateOptions.descending);

            this.updateLocalStorage(paginateParams);

            return this.getPreparedQuery();
        },
        getPreparedQuery() {
            let queryParams = { filter_name: this.options.filterName, fields: [] };

            forEach(this.usableFilters, (filterItem, key) => {
                if (filterItem.active) {
                    queryParams.fields.push(filterItem.name);
                    if (!isEmpty(filterItem.value) && this.isFilterSearchValid(filterItem)) {
                        queryParams[filterItem.name] = filterItem.value;
                        this.$set(this.usableFilters[key], 'valid', true);
                    } else {
                        this.$set(this.usableFilters[key], 'valid', false);
                    }
                }
            });

            var params = Object.assign(queryParams, this.options.queryParamsOverride || {});
            params = Object.assign(params, this.paginateOptions);
            params.sortBy = params.sortBy ? params.sortBy[0] : null;
            params.descending = params.sortDesc && params.sortDesc[0] !== undefined ? params.sortDesc[0] : 1;
            params.rowsPerPage = params.itemsPerPage;

            return params;
        },
        handleQuerySuccess(response) {
            this.items = response.data;
            this.totalItems = response.meta.total;
            this.loading = false;
        },
        handleQueryError(error) {
            console.log(error);
            this.$store.commit('setSnackbar', {message: 'Erreur serveur', type: 'error'});
        },
        loadFromLocalStorage() {
            let localStorageList = JSON.parse(localStorage.getItem(this.localStorageName));
            if (!localStorageList) return;
            if(localStorageList.filters) {
                forEach(this.usableFilters, (filter) => {
                    const filterLocalStorageListIndex = findIndex(localStorageList.filters, (localStorageFilter) => {
                        return localStorageFilter.name === filter.name
                    });
                    if(filterLocalStorageListIndex !== -1) {
                        const filterLocalStorage = localStorageList.filters[filterLocalStorageListIndex];
                        filter.active = filterLocalStorage ? filterLocalStorage.active : false;
                    }
                });
            }
            if (localStorageList.pagination) {
                this.paginateOptions.itemsPerPage = localStorageList.pagination;
            }
        },
        prepareExportValues() {
            this.exportValues = this.toHtmlArray(this.prepareQuery());
            this.loading = false;
        },
        /**
         * Retourne un array utilisé pour construire les inputs hidden nécessaires à envoyer les filtres en POST (non ajax)
         *
         * @param params
         * @returns {Array}
         */
        toHtmlArray(params) {
            let result = [];
            result.push({ key: 'filter_name', value: this.options.filterName });

            for (let key in params) {
                if (['page', 'itemsPerPage'].indexOf(key) !== -1) continue;

                if (Array.isArray(params[key])) {
                    for (let arrayKey in params[key]) {
                        result.push({ key: key + '[]', value: params[key][arrayKey] });
                    }
                } else if (typeof params[key] === 'object' && params[key] !== null) {
                    for (let objectKey in params[key]) {
                        result.push({ key: key + '[' + objectKey +']', value: params[key][objectKey] });
                    }
                } else {
                    result.push({key: key, value: params[key] });
                }
            }

            return result;
        },
        prepareFieldsForNewFilterStoring() {
            let result = {};
            forEach(this.usableFilters, filter => {
                if (filter.active && !isEmpty(filter.value) && this.isFilterSearchValid(filter)) {
                    result[filter.name] = filter.value
                } else if (filter.active) {
                    result[filter.name] = {};
                }
            });

            return result;
        },
        getStoredFilters() {
            getFilters(this.options.filterName)
                .then(response => this.$set(this, 'storedFilters', response.data))
                .catch(error => this.handleQueryError(error));
        },
        storeNewFilter(newFilterName) {
            const params = {
                filter_name: this.options.filterName,
                label: newFilterName,
                fields: this.prepareFieldsForNewFilterStoring()
            };
            this.saveFilterLoading = true;

            storeFilter(params)
                .then(() => this.getStoredFilters())
                .catch(error => this.handleQueryError(error))
                .finally(() => this.saveFilterLoading = false);
        },
        deleteStoredFilter(filterId) {
            this.deleteFilterLoading = true;
            deleteFilter(filterId)
                .then(() => this.getStoredFilters())
                .catch(error => this.handleQueryError(error))
                .finally(() => this.deleteFilterLoading = false);
        }
    },
}
</script>

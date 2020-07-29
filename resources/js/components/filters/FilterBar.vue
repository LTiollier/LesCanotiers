<template>
    <v-card class="mr-2" dusk="filter_bar">
        <v-row class="pa-2" no-gutters>
            <v-col class="px-3 text-left" cols="10">
                <div class="headline">
                    Filtres actifs
                </div>
            </v-col>
            <v-col class="text-right">
                <v-icon @click="$emit('close')">
                    mdi-close
                </v-icon>
            </v-col>
        </v-row>
        <v-row v-if="storedFilters.length" no-gutters>
            <v-col cols="12" class="px-3">
                <v-select
                    v-model="selectedStoredFilter"
                    :items="storedFilters"
                    item-text="label"
                    item-value="id"
                    label="Filtres enregistrés"
                    clearable
                    @change="setSelectedStoredFilter" />
                <v-divider />
            </v-col>
        </v-row>
        <v-row class="pa-2" no-gutters>
            <v-list dense>
                <v-list-group
                    v-for="filter in notHiddenFilters"
                    :key="filter.attribute"
                    v-model="filter.open">
                    <template v-slot:activator>
                        <v-list-item class="pa-0">
                            <v-list-item-action @click="stopPropagation">
                                <v-checkbox
                                    v-model="filter.active"
                                    update-filter
                                    :dusk="'toggle_' + filter.name"
                                    @change="change(filter.name)" />
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <template v-if="filter.active && filter.valid">
                                        <b>{{ filter.text }}</b>
                                    </template>
                                    <template v-else>
                                        {{ filter.text }}
                                    </template>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                    <filter-field
                        :filter="filter"
                        @change="change"
                        @filterReset="filterReset" />
                </v-list-group>
            </v-list>
        </v-row>
        <v-row no-gutters>
            <v-col cols="12" class="pb-3 text-center">
                <v-btn
                    :loading="saveFilterLoading"
                    d-inline
                    color="primary"
                    :disabled="!!selectedStoredFilter"
                    @click="openCreationConfirmDialog">
                    Sauver
                </v-btn>
                <v-btn
                    d-inline
                    color="secondary"
                    @click="selectedStoredFilterReset">
                    Reset
                </v-btn>
            </v-col>
            <v-col v-if="storedFilters.length" cols="12" class="text-center pb-3">
                <v-btn
                    v-if="selectedStoredFilter"
                    :loading="deleteFilterLoading"
                    color="primary"
                    @click.prevent="openDeletionConfirmDialog">
                    Supprimer ce filtre
                </v-btn>
            </v-col>
        </v-row>
        <v-dialog v-model="storedFiltersDeletionDialog" max-width="290">
            <v-card>
                <v-card-text>
                    Êtes-vous sûr de vouloir supprimer ce filtre ?
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="red darken-1"
                        text
                        @click="storedFiltersDeletionDialog = false">
                        Non
                    </v-btn>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="storedFilterDeleted">
                        Oui
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="storedFiltersCreationDialog" persistent max-width="600px">
            <v-card>
                <v-form
                    ref="saveFilterForm"
                    @submit.prevent="storedFilterCreate">
                    <v-card-title>
                        <span class="headline">Sauvegarder ce filtre</span>
                    </v-card-title>
                    <v-card-text>
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="newFilterName"
                                    label="Nom"
                                    counter="255"
                                    required />
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer />
                        <v-btn color="red darken-1" text @click="storedFiltersCreationDialog = false">
                            Annuler
                        </v-btn>
                        <v-btn type="submit" color="green darken-1" text>
                            Confirmer
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
import FilterField from './FilterField';

export default {
    name: "FilterBar",
    components: {
        FilterField
    },
    props: {
        filters: {
            type: Array,
            required: true
        },
        storedFilters: {
            type: Array,
            required: true,
        },
        saveFilterLoading: {
            type: Boolean,
            required: true
        },
        deleteFilterLoading: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            selectedStoredFilter: 0,
            storedFiltersDeletionDialog: false,
            storedFiltersCreationDialog: false,
            newFilterName: '',
        }
    },
    computed: {
        notHiddenFilters() {
            return this.filters.filter(filter => !filter.hide);
        }
    },
    watch: {
        storedFilters() {
            this.selectedStoredFilter = 0;
            this.storedFiltersDeletionDialog = false;
            this.storedFiltersCreationDialog = false;
            this.newFilterName = '';
        }
    },
    methods: {
        stopPropagation(event) {
            event.stopPropagation();
        },
        change(filterName) {
            this.selectedStoredFilter = 0;
            this.$emit('change', filterName);
        },
        filterReset(filterName) {
            this.selectedStoredFilter = 0;
            this.$emit('filterReset', filterName);
        },
        setSelectedStoredFilter(value) {
            this.$emit('storedFilterSelected', value)
        },
        selectedStoredFilterReset() {
            this.selectedStoredFilter = 0;
            this.$emit('storedFilterSelected', null);
        },
        storedFilterDeleted() {
            this.$emit('storedFilterDeleted', this.selectedStoredFilter);
        },
        openDeletionConfirmDialog() {
            this.storedFiltersDeletionDialog = true;
        },
        openCreationConfirmDialog() {
            this.storedFiltersCreationDialog = true;
        },
        storedFilterCreate() {
            if (this.$refs.saveFilterForm.validate()) {
                this.$emit('filterCreated', this.newFilterName);
            }
        },
    },
}
</script>
<style scoped>
    .v-list.v-sheet.v-sheet--tile {
        width: 100%;
    }
</style>

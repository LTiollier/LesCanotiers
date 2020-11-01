<template>
    <v-data-table
        :headers="headers"
        :items="items"
        :options.sync="pagination"
        :footer-props="footerOptions"
        :server-items-length="totalItems"
        :loading="loading"
        :items-per-page="itemsPerPage"
        no-data-text="Aucun résultat"
        dusk="resource-table"
        class="elevation-1">
        <template
            v-slot:item="{ item }">
            <tr
                :class="{'pointer_cursor': areItemsSelectable}"
                :dusk="'row-table-' + item.id"
                @click="goToItem(item)">
                <td
                    v-for="(key, i) in itemsKeys"
                    :key="i">
                    <template v-if="!(withDelete && i === itemsKeys.length - 1)">
                        {{ item[key] }}
                    </template>
                    <template v-else>
                        <v-icon
                            small
                            @click="$emit('delete', item)">
                            mdi-delete
                        </v-icon>
                    </template>
                </td>
            </tr>
        </template>
    </v-data-table>
</template>

<script>
import {map, filter, cloneDeep} from 'lodash';
export default {
    name: "TableFilterable",
    props: {
        filters: {
            type: Array,
            required: true
        },
        loading: {
            type: Boolean,
            default: true,
        },
        items: {
            type: Array,
            default: function () {
                return []
            }
        },
        paginateOptions: {
            type: Object,
            default: function () {
                return {}
            }
        },
        totalItems: {
            type: Number,
            default: 0,
        },
        itemRouteName: {
            type: String,
            default: ''
        },
        itemType: {
            type: String,
            default: '',
        },
        itemKey: {
            type: String,
            default: '',
        },
        withDelete: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            total: 0,
            pagination: {},
            footerOptions: {
                'items-per-page-options': [10, 25, 50, 100, { "text": "Tous", "value": -1 }],
                'items-per-page-text': "Nombre d'entrées par page"
            },
            itemsPerPage: 10,
        }
    },
    computed: {
        headers() {
            let headers= map(filter(cloneDeep(this.filters), {active: true}), (item) => {
                item.value = item.name;
                return item;
            });
            if (this.withDelete) {
                headers.push({ text: 'Actions', value: 'actions', sortable: false })
            }
            return headers;
        },
        itemsKeys() {
            return map(this.headers, (header) => {
                return header.name;
            });
        },
        areItemsSelectable() {
            return this.itemRouteName !== '';
        }
    },
    watch: {
        pagination(params) {
            this.$emit('paginate', params);
        },
        paginateOptions(value) {
            this.pagination = value;
        }
    },
    mounted() {
        this.pagination = this.paginateOptions;
    },
    methods: {
        goToItem: function (item) {
            if(this.areItemsSelectable) {
                let id = this.getItemId(item);
                let data = {};
                data[this.itemType] = id;
                this.$inertia.visit(route(this.itemRouteName, data));
            }
        },
        getItemId: function (item) {
            if(this.itemKey) {
                return item[this.itemKey];
            }
            let idValue = null;
            if(item && typeof item === "object" && item.id) {
                idValue = item.id;
            } else {
                // Récupération de la propriété de l'object qui commence par "id_"
                let idProperty = null;
                for (let property in item) {
                    if (property.startsWith('id_')) idProperty = property;
                }
                // Récupération de la valeur liée à cette propriété
                idValue = item[ idProperty ];
            }
            return idValue;
        }
    }
}
</script>

<template>
    <base-layout>
        <v-container class="mt-6">
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Liste des fruits/légumes</h1>
                </v-col>
            </v-row>
            <item-list
                :filters="filterConfigs.filters"
                :options="options"
                with-filters
                with-export
                create-route="vegetables.create"
                create-text="Ajouter un fruit/légume" />
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ItemList from "../../components/filters/ItemList";
export default {
    name: "VegetableIndex",
    components: {ItemList, BaseLayout},
    props: {
        filterConfigs: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            options: {
                filterName: this.filterConfigs.name,
                pageName: this.filterConfigs.name,
                itemRouteName: 'vegetables.edit',
                itemType: 'vegetable',
            }
        }
    }
}
</script>

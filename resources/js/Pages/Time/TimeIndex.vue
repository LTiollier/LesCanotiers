<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Liste de mes temps</h1>
                </v-col>
            </v-row>
            <item-list
                :filters="filterConfigs.filters"
                :options="options"
                with-filters
                with-delete
                create-route="home"
                create-text="Ajouter un temps"
                @delete="deleteTime" />
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ItemList from "../../components/filters/ItemList";

export default {
    name: "TimeIndex",
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
                itemType: 'time',
            }
        }
    },
    methods: {
        deleteTime(time) {
            return this.$inertia.delete(this.route('times.destroy', {time: time.id}));
        }
    }
}
</script>

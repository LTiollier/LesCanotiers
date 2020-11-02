<template>
    <autocomplete-model
        :original-value="originalValue"
        :multiple="multiple"
        :label="labelText"
        :query="query"
        item-text="name"
        :error-messages="errorMessages"
        @update:originalValue="updateValue" />
</template>

<script>
import {getModelFiltered} from "../../../api/filterService";
import {autocompleteMixin} from "../../../mixins/autocomplete";

export default {
    name: "SelectVegetableCategory",
    mixins: [autocompleteMixin],
    computed: {
        labelText() {
            return this.label ?? this.multiple ? 'catégorie Fruit/Légume' : 'catégories Fruit/Légume';
        }
    },
    methods: {
        query(search) {
            let data = {
                name: {
                    strategy: "contains",
                    term: search,
                },
                filter_name: "vegetableCategories",
                fields: ["id", "name"],
                page: 1,
                sortBy: 'name',
                descending: 0,
                rowsPerPage: -1,
            };
            return getModelFiltered(data);
        },
    },
}
</script>

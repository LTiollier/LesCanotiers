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
    name: "SelectVegetable",
    mixins: [autocompleteMixin],
    computed: {
        labelText() {
            return this.label ?? this.multiple ? 'Fruits/Légumes' : 'Fruit/Légume';
        }
    },
    methods: {
        query(search) {
            let data = {
                name: {
                    strategy: "contains",
                    term: search,
                },
                filter_name: "vegetables",
                fields: ["id", "name"],
                page: 1,
                sortBy: 'name',
                descending: 0,
                rowsPerPage: -1,
                _token: this.$page.csrf_token
            };
            return getModelFiltered(data);
        },
    },
}
</script>

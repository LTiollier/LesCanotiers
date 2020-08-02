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
    name: "SelectParcel",
    mixins: [autocompleteMixin],
    computed: {
        labelText() {
            return this.label ?? this.multiple ? 'Parcelles' : 'Parcelle';
        }
    },
    methods: {
        query(search) {
            let data = {
                name: {
                    strategy: "contains",
                    term: search,
                },
                filter_name: "parcels",
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

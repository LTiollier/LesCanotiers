<template>
    <v-list-item class="pa-0">
        <v-list-item-content class="pa-0">
            <component
                :is="fieldType"
                class="pr-0 pt-0"
                :filter="filter"
                @change="change"
                @filterReset="filterReset" />
        </v-list-item-content>
    </v-list-item>
</template>

<script>
import { capitalize } from "../../helpers/string";
import { debounce } from 'lodash';
import TextField from './fields/TextField';
import SelectField from './fields/SelectField';
import DateField from './fields/DateField';
import CheckboxField from './fields/CheckboxField';
import NumberField from './fields/NumberField';

export default {
    name: "FilterField",
    components: {
        TextField,
        SelectField,
        DateField,
        CheckboxField,
        NumberField
    },
    props: {
        filter: {
            type: Object,
            required: true
        }
    },
    computed: {
        fieldType() {
            if (this.filter.field.type === 'datetime') {
                return 'DateField';
            }

            return capitalize(this.filter.field.type) + 'Field';
        }
    },
    methods: {
        change: debounce(function(filterName) {
            this.$emit('change', filterName);
        }, 500),
        filterReset(filterName) {
            this.$emit('filterReset', filterName);
        }
    },
}
</script>

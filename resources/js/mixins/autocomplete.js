import AutocompleteModel from "../components/inputs/selects/AutocompleteModel";

export const autocompleteMixin = {
    components: {AutocompleteModel},
    props: {
        originalValue: {
            required: false,
            type: [Array, Object],
            default: () => { return [] }
        },
        multiple: {
            required: false,
            type: Boolean,
            default: false
        },
        label: {
            required: false,
            type: String,
            default: ''
        },
        errorMessages: {
            required: false,
            type: Array,
            default: () => { return []; }
        },
        cacheItems: {
            required: false,
            type: Boolean,
            default: true,
        },
        itemValue: {
            required: false,
            type: String,
            default: ''
        }
    },
    methods: {
        updateValue(value) {
            this.$emit('update:originalValue', value);
        }
    }
};

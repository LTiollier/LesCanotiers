import {forEach} from 'lodash';
export const fieldMixin = {
    props: {
        filter: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            value: null
        }
    },
    computed: {
        label() {
            return this.filter.text ? this.filter.text : '';
        },
        options() {
            let options = [];
            if(this.filter.field && this.filter.field.options) {
                forEach(this.filter.field.options, (object) => {
                    options.push({
                        text: object.text,
                        value: object.value
                    });
                });
            }
            return options;
        },
    },
    methods: {
        filterReset() {
            this.$emit('filterReset', this.filter.name);
        },
        emit() {
            this.$emit('change', this.filter.name);
        },
    }
};

export default fieldMixin;

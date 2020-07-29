<template>
    <v-autocomplete
        v-model="value"
        :items="items"
        :loading="loading"
        :search-input.sync="search"
        :item-text="itemText"
        :item-value="itemValue"
        :label="label"
        :multiple="multiple"
        :chips="multiple"
        clearable
        :cache-items="cacheItems"
        :deletable-chips="multiple"
        :return-object="!itemValue"
        :error-messages="errorMessages"
        hide-no-data
        @change="() => { $emit('update:originalValue', value); $emit('change', value); }" />
</template>

<script>
import {debounce} from "lodash";

export default {
    name: "AutocompleteModel",
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
        query: {
            required: true,
            type: Function,
        },
        cacheFunction: {
            require: false,
            type: Function,
            default: function(originalValue) {
                return originalValue;
            }
        },
        itemText: {
            require: false,
            type: String,
            default: 'name'
        },
        itemValue: {
            required: false,
            type: String,
            default: ''
        },
        cacheItems: {
            required: false,
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            value: null,
            loading: false,
            search: '',
            items: []
        }
    },
    watch: {
        search: debounce(function() {
            if (this.loading || this.search === null) return;
            if (this.search === '') {
                this.items = [];
                return;
            }
            this.loading = true;

            this.query(this.search).then(({data}) => {
                this.items = data.data;
            }).catch(err => {
                console.log(err)
            }).finally(() => (this.loading = false));
        }, 400),
    },
    created() {
        if (this.originalValue && (this.originalValue.id || this.originalValue.length)) {
            let data = this.cacheFunction(this.originalValue);
            if (this.multiple) {
                this.items = data;
            } else {
                this.items.push(data);
            }
            this.value = data;
        }
    },
}
</script>

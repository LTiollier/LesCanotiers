<template>
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="290px">
        <template v-slot:activator="{ on }">
            <v-text-field
                v-model="dateFormatted"
                :label="label"
                persistent-hint
                prepend-icon="mdi-calendar"
                :error-messages="errorMessages"
                clearable
                @click:clear="clear"
                @blur="date = parseDate(dateFormatted)"
                v-on="on" />
        </template>
        <v-date-picker
            v-model="localValue"
            no-title
            locale="fr-fr"
            :min="min"
            @input="changeValue" />
    </v-menu>
</template>

<script>
export default {
    name: "DateInput",
    props: {
        label: {
            type: String,
            default: ''
        },
        value: {
            type: String,
            default: '',
        },
        min: {
            type: String,
            required: false,
            default: '',
        },
        errorMessages: {
            type: Array,
            required: false,
            default: () => { return []; }
        }
    },
    data() {
        return {
            localValue: null,
            dateFormatted: null,
            menu: null
        }
    },
    watch: {
        value() {
            this.localValue = this.value;
            this.dateFormatted = this.formatDate(this.value);
        },
    },
    mounted() {
        this.localValue = this.value;
        this.dateFormatted = this.formatDate(this.value);
    },
    methods: {
        parseDate(date) {
            if (!date) return null;
            const [month, day, year] = date.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        },
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split('-');
            return `${day}/${month}/${year}`;
        },
        changeValue() {
            this.menu = false;
            this.$emit('input', this.localValue);
        },
        clear() {
            this.localValue = null;
            this.$emit('input', this.localValue);
        }
    }
}
</script>

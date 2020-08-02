<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="290px">
        <template v-slot:activator="{ on }">
            <v-text-field
                :value="originalDate"
                :label="label"
                :clearable="clearable"
                readonly
                :class="{'d-inline-block': inlineBlock}"
                :error-messages="errorMessages"
                @click:clear="clearDate"
                v-on="on" />
        </template>
        <v-date-picker v-model="date" locale="fr-fr" :min="min" @input="selectDate" />
    </v-menu>
</template>

<script>
import {formatDate} from "../../helpers/date";

export default {
    name: "DateInput",
    props: {
        originalDate: {
            required: false,
            type: String,
            default: ''
        },
        label: {
            required: false,
            type: String,
            default: 'Selection de la date'
        },
        errorMessages: {
            required: false,
            type: Array,
            default: () => {return []}
        },
        min: {
            required: false,
            type: String,
            default: null
        },
        inlineBlock: {
            type: Boolean,
            default: false,
        },
        inputFormat: {
            type: String,
            default: 'DD/MM/YYYY'
        },
        format: {
            type: String,
            default: 'DD/MM/YYYY'
        },
        clearable: {
            type: Boolean,
            default: true,
        }
    },
    data() {
        return {
            date: null,
            menu: false,
        }
    },
    mounted() {
        this.date = formatDate(this.originalDate, 'YYYY-MM-DD', this.format);
    },
    methods: {
        selectDate() {
            this.menu = false;
            this.$emit('update:originalDate', formatDate(this.date, this.format));
        },
        clearDate() {
            this.date = null;
            this.$emit('update:originalDate', null);
        },
    }
}
</script>

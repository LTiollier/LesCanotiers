<template>
    <v-row no-gutters class="pa-3 pr-3">
        <v-col v-if="resetable" class="text-right">
            <v-btn
                text
                icon
                color="red lighten-2"
                @click="filterReset()">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-col>
        <v-col cols="12">
            <v-select
                v-model="filter.value.strategy"
                :items="selectItems"
                @input="emit" />
        </v-col>
        <v-col cols="12">
            <date-input
                v-if="showFirstInput"
                v-model="filter.value.date"
                :label="field1Label"
                @input="emit" />
        </v-col>
        <v-col cols="12">
            <date-input
                v-if="showSecondInput"
                v-model="filter.value.second_date"
                label="Jusqu'à (inclus)"
                @input="emit" />
        </v-col>
    </v-row>
</template>

<script>
import fieldMixin from  '../../../mixins/field';
import DateInput from '../DateInputFilter';

export default {
    name: "DateField",
    components: {
        DateInput
    },
    mixins: [fieldMixin],
    props: {
        resetable: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            selectItems: [
                { text: 'Égal', value: 'equals' },
                { text: 'Entre', value:'between' },
                { text: 'Ce mois-ci', value:'current_month' },
                { text: 'Cette semaine', value:'current_week' },
                { text: 'Le mois dernier', value:'past_month' },
                { text: 'La semaine dernière', value:'past_week' },
            ],
        }
    },
    computed: {
        field1Label() {
            return this.filter.value.strategy === 'between' ? 'À partir de (inclus)' : this.label;
        },
        showFirstInput() {
            return this.filter.value.strategy === 'equals' || this.filter.value.strategy === 'between';
        },
        showSecondInput() {
            return this.filter.value.strategy === 'between';
        },
    },
}
</script>

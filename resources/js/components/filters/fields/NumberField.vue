<template>
    <v-row no-gutters class="pa-3 pr-3">
        <v-col
            cols="12"
            class="text-lg-right">
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
            <v-text-field
                v-model="filter.value.term"
                :label="firstInputTypeToLabel"
                @input="emit" />
            <v-text-field
                v-if="showSecondInput"
                v-model="filter.value.second_term"
                :label="secondInputTypeToLabel"
                @input="emit" />
        </v-col>
    </v-row>
</template>

<script>
import fieldMixin from  '../../../mixins/field';

export default {
    name: "NumberField",
    mixins: [fieldMixin],
    data() {
        return {
            numberValue: null,
            secondNumberValue: null,
            selectItems: [
                { text: 'Égal', value: 'equals' },
                { text: 'Entre', value:'between' },
                { text: 'Supérieur ou égal', value:'bigger' },
                { text: 'Inférieur ou égal', value:'lower' },
            ],
            select: {}
        }
    },
    computed: {
        firstInputTypeToLabel() {
            return this.filter.value.strategy === 'between' ? 'Entre' : this.label;
        },
        secondInputTypeToLabel() {
            return this.filter.value.strategy === 'between' ? 'Et' : this.label;
        },
        showSecondInput() {
            return this.filter.value.strategy === 'between';
        }
    }
}
</script>

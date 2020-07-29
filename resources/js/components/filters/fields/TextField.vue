<template>
    <v-row no-gutters class="pa-3 pr-3">
        <v-col cols="12" class="text-right">
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
                :label="label"
                @input="emit" />
        </v-col>
    </v-row>
</template>

<script>
import fieldMixin from  '../../../mixins/field';

export default {
    name: "TextField",
    mixins: [fieldMixin],
    props: {
        filter: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            selectItems: [
                { text: 'Contient', value: 'contains' },
                { text: 'Ne contient pas', value:'ignore' },
            ],
        }
    },
}
</script>

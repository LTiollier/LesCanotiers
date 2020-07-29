<template>
    <v-row no-gutters class="pa-3 pr-3">
        <v-col cols="12" class="text-lg-right">
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
                v-model="filter.value.term"
                :items="options"
                :label="label"
                item-text="text"
                item-value="value"
                @input="emit" />
        </v-col>
    </v-row>
</template>

<script>
import fieldMixin from  '../../../mixins/field';

export default {
    name: "SelectField",
    mixins: [fieldMixin],
}
</script>

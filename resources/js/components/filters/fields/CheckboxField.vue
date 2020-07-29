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
            <v-checkbox
                v-for="(option, key) in options"
                :key="key"
                v-model="filter.value"
                :label="option.text"
                :value="option.value"
                height="10"
                class="no-v-messages"
                @change="emit" />
        </v-col>
    </v-row>
</template>

<script>
import fieldMixin from  '../../../mixins/field';

export default {
    name: "CheckboxField",
    mixins: [fieldMixin],
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-row no-gutters class="mb-10">
            <v-col cols="12" class="text-center">
                <h1>
                    <slot name="title" />
                </h1>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col cols="12" md="6" class="pa-3">
                <select-vegetable :original-value.sync="cycle.vegetable" />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <select-parcel :original-value.sync="cycle.parcel" />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <date-input v-model="cycle.starts_at" label="Commence le" :error-messages="startsAtErrors" />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <date-input v-model="cycle.ends_at" label="Finit le" :error-messages="endsAtErrors" />
            </v-col>
            <v-col cols="12">
                <v-btn class="mr-4" color="primary" type="submit">
                    <slot name="button" />
                </v-btn>
                <v-btn v-if="withDelete" class="mr-4" color="error" @click="$emit('deleteCycle')">
                    Supprimer
                </v-btn>
            </v-col>
        </v-row>
    </form>
</template>

<script>

import SelectVegetable from "../inputs/selects/SelectVegetable";
import SelectParcel from "../inputs/selects/SelectParcel";
import DateInput from "../filters/DateInputFilter";
export default {
    name: "CycleForm",
    components: {DateInput, SelectParcel, SelectVegetable},
    props: {
        cycle: {
            required: true,
            type: Object
        },
        withDelete: {
            required: false,
            type: Boolean,
            default: false
        }
    },
    computed: {
        nameErrors () {
            return this.$serverErrors('name');
        },
        startsAtErrors() {
            return this.$serverErrors('starts_at');
        },
        endsAtErrors() {
            return this.$serverErrors('ends_at');
        }
    },
    methods: {
        submit () {
            this.$emit('submit');
        },
    }
}
</script>

<style scoped>
    form {
        width: 100%;
    }
</style>

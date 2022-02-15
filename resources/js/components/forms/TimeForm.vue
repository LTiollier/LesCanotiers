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
                <v-text-field
                    :value="cycleName"
                    label="Cycle"
                    disabled />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    :value="time.activity.name"
                    label="Activity"
                    disabled />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    :value="time.user.name"
                    label="Utilisateur"
                    disabled />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="time.quantity"
                    type="number"
                    label="Quantité" />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <date-input
                    v-model="time.date"
                    :error-messages="dateErrors"
                    label="Date"
                    input-format="YYYY-MM-DD"
                    required />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-select
                    v-model="time.minutes"
                    :items="times"
                    :error-messages="minutesErrors"
                    label="Minutes"
                    required />
            </v-col>

            <v-col cols="12">
                <v-btn class="mr-4" color="primary" type="submit">
                    <slot name="button" />
                </v-btn>
                <v-btn class="mr-4" color="error" @click="$emit('deleteTime')">
                    Supprimer
                </v-btn>
            </v-col>
        </v-row>
    </form>
</template>

<script>

import {moment} from "../../helpers/date";
import DateInput from "../inputs/DateInput";

export default {
    name: "TimeForm",
    components: {DateInput},
    props: {
        time: {
            required: true,
            type: Object
        },
    },
    data() {
        return {
            times: [
                {text: '30 minutes', value: 30},
                {text: '1 heure', value: 60},
                {text: '1 heure 30 minutes', value: 90},
                {text: '2 heures', value: 120},
                {text: '2 heures 30 minutes', value: 150},
                {text: '3 heures', value: 180},
                {text: '3 heures 30 minutes', value: 210},
                {text: '4 heures', value: 240},
                {text: '4 heures 30 minutes', value: 270},
                {text: '5 heures', value: 300},
                {text: '5 heures 30 minutes', value: 330},
                {text: '6 heures', value: 360},
                {text: '6 heures 30 minutes', value: 390},
                {text: '7 heures', value: 420},
                {text: '7 heures 30 minutes', value: 450},
                {text: '8 heure', value: 480},
                {text: '8 heure 30 minutes', value: 510},
                {text: '9 heures', value: 540},
                {text: '9 heures 30 minutes', value: 570},
                {text: '10 heures', value: 600},
                {text: '10 heures 30 minutes', value: 630},
                {text: '11 heures', value: 660},
                {text: '11 heures 30 minutes', value: 690},
                {text: '12 heures', value: 720},
                {text: '12 heures 30 minutes', value: 750},
                {text: '13 heures', value: 780},
                {text: '13 heures 30 minutes', value: 810},
                {text: '14 heures', value: 840},
            ]
        }
    },
    computed: {
        dateErrors () {
            return this.$serverErrors('date');
        },
        minutesErrors () {
            return this.$serverErrors('minutes');
        },
        cycleName() {
            return this.time.cycle.vegetable.name + ' - '
                + this.time.cycle.parcel.name + ' ('
                + this.getFrenchDateStyle(this.time.cycle.starts_at) + ' au '
                + this.getFrenchDateStyle(this.time.cycle.ends_at) + ')';
        }
    },
    methods: {
        submit () {
            this.$emit('submit');
        },
        getFrenchDateStyle(date) {
            return moment(date).format("L");
        },
    }
}
</script>

<style scoped>
    form {
        width: 100%;
    }
</style>

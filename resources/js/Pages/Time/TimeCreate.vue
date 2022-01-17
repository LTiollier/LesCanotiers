<template>
    <base-layout>
        <v-container class="mt-6">
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Ajout d'un temps</h1>
                </v-col>
                <v-col cols="12" class="text-center">
                    <v-stepper
                        v-model="step"
                        vertical>
                        <v-stepper-step
                            editable
                            :complete="step > 1"
                            step="1">
                            Choisir un cycle
                        </v-stepper-step>

                        <v-stepper-content step="1">
                            <list-selector :items="cycles" @click="setSelectedValue($event, 'cycle')">
                                <template v-slot:default="slotProps">
                                    {{ slotProps.item.vegetable.name }} - {{ slotProps.item.parcel.name }}
                                    <br>({{ getFrenchDateStyle(slotProps.item.starts_at) }} au {{ slotProps.item.ends_at ? getFrenchDateStyle(slotProps.item.ends_at) : '--/--/---' }})
                                </template>
                            </list-selector>
                        </v-stepper-content>

                        <v-stepper-step
                            :editable="step > 2"
                            :complete="step > 2"
                            step="2">
                            Choisir une activité
                        </v-stepper-step>

                        <v-stepper-content step="2">
                            <list-selector :items="activities" @click="setSelectedValue($event, 'activity')" />
                        </v-stepper-content>

                        <v-stepper-step
                            :editable="step > 3"
                            :complete="step > 3"
                            step="3">
                            Rentrer un temps
                        </v-stepper-step>

                        <v-stepper-content step="3">
                            <v-select
                                v-model="time"
                                :items="times"
                                label="Temps"
                                @change="step++" />
                        </v-stepper-content>

                        <v-stepper-step
                            :editable="step > 4"
                            :complete="step > 4"
                            step="4">
                            Rentrer la quantité récolté
                        </v-stepper-step>

                        <v-stepper-content step="4">
                            <v-text-field
                                v-model="quantity"
                                label="Quantité (Kg)"
                                @change="step++" />
                            <v-btn @click="step++">
                                Passer
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-step
                            :editable="step > 5"
                            :complete="step > 5"
                            step="5">
                            Choisir une date
                        </v-stepper-step>

                        <v-stepper-content step="5">
                            <date-input v-model="date" input-format="YYYY-MM-DD" />
                            <v-btn v-if="date" elevation="2" color="primary" @click="submit">
                                Ajouter
                            </v-btn>
                        </v-stepper-content>
                    </v-stepper>
                </v-col>
            </v-row>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ListSelector from "../../components/ListSelector";
import {moment} from "../../helpers/date";
import DateInput from "../../components/inputs/DateInput";

export default {
    name: "TimeCreate",
    components: {DateInput, ListSelector, BaseLayout},
    props: {
        cycles: {
            required: true,
            type: Array
        },
        activities: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            step: 1,
            cycle: null,
            activity: null,
            time: null,
            quantity: null,
            date: moment().format("YYYY-MM-DD"),
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
            ]
        }
    },
    methods: {
        setSelectedValue($event, key) {
            this[key] = $event;
            this.step++;
        },
        getFrenchDateStyle(date) {
            return moment(date).format("L");
        },
        submit() {
            return this.$inertia.post(this.route('times.store'), {
                minutes: this.time,
                cycle: this.cycle,
                activity: this.activity,
                date: this.date,
                quantity: this.quantity,
                user: this.$page.auth,
                _token: this.$page.csrf_token
            }, { preserveState: false })
        }
    }
}
</script>

<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Ajout d'un temps</h1>
                </v-col>
                <v-col cols="12" class="text-center">
                    <v-stepper
                        v-model="step"
                        vertical>
                        <v-stepper-step
                            :complete="step > 1"
                            step="1">
                            Choisir une catégorie de légume
                        </v-stepper-step>

                        <v-stepper-content step="1">
                            <list-selector :items="vegetableCategories" @click="setSelectedValue($event, 'vegetableCategory')" />
                        </v-stepper-content>

                        <v-stepper-step
                            :complete="step > 2"
                            step="2">
                            Choisir un légume
                        </v-stepper-step>

                        <v-stepper-content step="2">
                            <list-selector :items="vegetables" @click="setSelectedValue($event, 'vegetable')" />
                        </v-stepper-content>

                        <v-stepper-step
                            :complete="step > 3"
                            step="3">
                            Choisir un cycle
                        </v-stepper-step>

                        <v-stepper-content step="3">
                            <list-selector :items="vegetables" @click="setSelectedValue($event, 'cycle')" />
                        </v-stepper-content>

                        <v-stepper-step
                            :complete="step > 4"
                            step="4">
                            Rentrer un temps
                        </v-stepper-step>

                        <v-stepper-content step="4">
                            coucou
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

export default {
    name: "TimeCreate",
    components: {ListSelector, BaseLayout},
    props: {
        vegetableCategories: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            step: 1,
            vegetableCategory: null,
            vegetable: null,
            cycle: null
        }
    },
    computed: {
        vegetables() {
            if (this.vegetableCategory === null) return [];
            return this.vegetableCategory.vegetables;
        },
        cycles() {
            if (this.vegetable === null) return [];
            return this.vegetable.cycles;
        }
    },
    methods: {
        setSelectedValue($event, key) {
            console.log($event, key);
            this[key] = $event;
            this.step++;
        },
        getFrenchDateStyle(date) {
            return moment(date).format("L");
        }
    }
}
</script>

<style scoped>

</style>

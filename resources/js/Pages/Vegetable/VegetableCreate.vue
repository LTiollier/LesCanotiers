<template>
    <base-layout>
        <v-container class="mt-6">
            <vegetable-form :vegetable="vegetable" :vegetable-categories="vegetableCategories" @submit="submit">
                <template #title>
                    Création d'un fruit/légume
                </template>
                <template #button>
                    Créer
                </template>
            </vegetable-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import VegetableForm from "../../components/forms/VegetableForm";

export default {
    name: "VegetableCreate",
    components: {VegetableForm, BaseLayout},
    props: {
        vegetableCategories: {
            required: true,
            type: Array,
        }
    },
    data() {
        return {
            vegetable: {},
        }
    },
    methods: {
        submit() {
            this.vegetable._token = this.$page.csrf_token;
            return this.$inertia.post(this.route('vegetables.store'), this.vegetable)
        }
    }
}
</script>

<template>
    <base-layout>
        <v-container class="mt-6">
            <vegetable-category-form :vegetable-category="vegetableCategory" @submit="submit">
                <template #title>
                    Création d'une categorie de fruit/légume
                </template>
                <template #button>
                    Créer
                </template>
            </vegetable-category-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import VegetableCategoryForm from "../../components/forms/VegetableCategoryForm";

export default {
    name: "VegetableCategoryCreate",
    components: {VegetableCategoryForm, BaseLayout},
    data() {
        return {
            vegetableCategory: {},
        }
    },
    methods: {
        submit() {
            this.vegetableCategory._token = this.$page.csrf_token;
            return this.$inertia.post(this.route('vegetableCategories.store'), this.vegetableCategory)
        }
    }
}
</script>

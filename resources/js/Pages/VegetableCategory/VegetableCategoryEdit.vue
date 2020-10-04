<template>
    <base-layout>
        <v-container>
            <vegetable-category-form :vegetable-category="vegetableCategory" with-delete @submit="submit" @deleteVegetableCategory="deleteVegetableCategory">
                <template #title>
                    Edition d'une catégorie d'un fruit/légume
                </template>
                <template #button>
                    Enregistrer
                </template>
            </vegetable-category-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import VegetableCategoryForm from "../../components/forms/VegetableCategoryForm";

export default {
    name: "VegetableCategoryEdit",
    components: {VegetableCategoryForm, BaseLayout},
    props: {
        vegetableCategory: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('vegetableCategories.update', {vegetableCategory: this.vegetableCategory.id }), this.vegetableCategory)
        },
        deleteVegetableCategory() {
            return this.$inertia.delete(this.route('vegetableCategories.destroy', {vegetableCategory: this.vegetableCategory.id}));
        }
    }
}
</script>

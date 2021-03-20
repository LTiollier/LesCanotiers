<template>
    <base-layout>
        <v-container class="mt-6">
            <vegetable-form :vegetable="vegetable" with-delete @submit="submit" @deleteVegetable="deleteVegetable">
                <template #title>
                    Edition d'un fruit/légume
                </template>
                <template #button>
                    Enregistrer
                </template>
            </vegetable-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import VegetableForm from "../../components/forms/VegetableForm";

export default {
    name: "VegetableEdit",
    components: {VegetableForm, BaseLayout},
    props: {
        vegetable: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('vegetables.update', {vegetable: this.vegetable.id }), this.vegetable)
        },
        deleteVegetable() {
            return this.$inertia.delete(this.route('vegetables.destroy', {vegetable: this.vegetable.id}));
        }
    }
}
</script>

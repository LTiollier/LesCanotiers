<template>
    <base-layout>
        <v-container>
            <parcel-form :parcel="parcel" @submit="submit">
                <template #title>
                    Création d'une parcelle
                </template>
                <template #button>
                    Créer
                </template>
            </parcel-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ParcelForm from "../../components/forms/ParcelForm";

export default {
    name: "ParcelCreate",
    components: {ParcelForm, BaseLayout},
    data() {
        return {
            parcel: {},
        }
    },
    methods: {
        submit() {
            return this.$inertia.post(this.route('parcels.store'), this.parcel)
        }
    }
}
</script>

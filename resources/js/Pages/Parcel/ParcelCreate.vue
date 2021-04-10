<template>
    <base-layout>
        <v-container class="mt-6">
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
            this.parcel._token = this.$page.csrf_token;
            return this.$inertia.post(this.route('parcels.store'), this.parcel)
        }
    }
}
</script>

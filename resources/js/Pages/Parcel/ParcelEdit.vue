<template>
    <base-layout>
        <v-container>
            <parcel-form :parcel="parcel" with-delete @submit="submit" @deleteParcel="deleteParcel">
                <template #title>
                    Edition d'une parcelle
                </template>
                <template #button>
                    Enregistrer
                </template>
            </parcel-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ParcelForm from "../../components/forms/ParcelForm";

export default {
    name: "ParcelEdit",
    components: {ParcelForm, BaseLayout},
    props: {
        parcel: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('parcels.update', {parcel: this.parcel.id }), this.parcel)
        },
        deleteParcel() {
            return this.$inertia.delete(this.route('parcels.destroy', {parcel: this.parcel.id}));
        }
    }
}
</script>

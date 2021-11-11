<template>
    <base-layout>
        <v-container class="mt-6">
            <cycle-form :cycle="cycle" :vegetables="vegetables" :parcels="parcels" @submit="submit">
                <template #title>
                    Création d'un cycle
                </template>
                <template #button>
                    Créer
                </template>
            </cycle-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import CycleForm from "../../components/forms/CycleForm";

export default {
    name: "CycleCreate",
    components: {CycleForm, BaseLayout},
    props: {
        vegetables: {
            required: true,
            type: Array
        },
        parcels: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            cycle: {},
        }
    },
    methods: {
        submit() {
            this.cycle._token = this.$page.csrf_token;
            return this.$inertia.post(this.route('cycles.store'), this.cycle)
        }
    }
}
</script>

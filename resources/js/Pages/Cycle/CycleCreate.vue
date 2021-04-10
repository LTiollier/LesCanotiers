<template>
    <base-layout>
        <v-container class="mt-6">
            <cycle-form :cycle="cycle" @submit="submit">
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

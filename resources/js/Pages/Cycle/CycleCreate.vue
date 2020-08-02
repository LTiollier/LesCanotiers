<template>
    <base-layout>
        <v-container>
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
            return this.$inertia.post(this.route('cycles.store'), this.cycle)
        }
    }
}
</script>

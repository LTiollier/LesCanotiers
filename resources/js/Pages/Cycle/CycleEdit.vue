<template>
    <base-layout>
        <v-container class="mt-6">
            <cycle-form :cycle="cycle" with-delete @submit="submit" @deleteCycle="deleteCycle">
                <template #title>
                    Edition d'un cycle
                </template>
                <template #button>
                    Enregistrer
                </template>
            </cycle-form>

            <cycle-report :cycle="cycle" class="mt-6" />
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import CycleForm from "../../components/forms/CycleForm";
import CycleReport from "../../components/CycleReport";

export default {
    name: "CycleEdit",
    components: {CycleReport, CycleForm, BaseLayout},
    props: {
        cycle: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('cycles.update', {cycle: this.cycle.id }), this.cycle)
        },
        deleteCycle() {
            return this.$inertia.delete(this.route('cycles.destroy', {cycle: this.cycle.id}));
        }
    }
}
</script>

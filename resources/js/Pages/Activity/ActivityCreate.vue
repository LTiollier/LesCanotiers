<template>
    <base-layout>
        <v-container>
            <activity-form :activity="activity" @submit="submit">
                <template #title>
                    Création d'une activité
                </template>
                <template #button>
                    Créer
                </template>
            </activity-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ActivityForm from "../../components/forms/ActivityForm";

export default {
    name: "ActivityCreate",
    components: {ActivityForm, BaseLayout},
    data() {
        return {
            activity: {},
        }
    },
    methods: {
        submit() {
            return this.$inertia.post(this.route('activities.store'), this.activity)
        }
    }
}
</script>

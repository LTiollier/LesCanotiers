<template>
    <base-layout>
        <v-container class="mt-6">
            <activity-form :activity="activity" with-delete @submit="submit" @deleteActivity="deleteActivity">
                <template #title>
                    Edition d'une activité
                </template>
                <template #button>
                    Enregistrer
                </template>
            </activity-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import ActivityForm from "../../components/forms/ActivityForm";

export default {
    name: "ActivityEdit",
    components: {ActivityForm, BaseLayout},
    props: {
        activity: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('activities.update', {activity: this.activity.id }), this.activity)
        },
        deleteActivity() {
            return this.$inertia.delete(this.route('activities.destroy', {activity: this.activity.id}));
        }
    }
}
</script>

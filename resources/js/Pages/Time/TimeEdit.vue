<template>
    <base-layout>
        <v-container class="mt-6">
            <time-form :time="time" with-delete @submit="submit" @deleteTime="deleteTime">
                <template #title>
                    Edition d'un temps
                </template>
                <template #button>
                    Enregistrer
                </template>
            </time-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import TimeForm from "../../components/forms/TimeForm";

export default {
    name: "TimeEdit",
    components: {TimeForm, BaseLayout},
    props: {
        time: {
            required: true,
            type: Object
        }
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('times.update', {time: this.time.id }), this.time)
        },
        deleteTime() {
            return this.$inertia.delete(this.route('times.destroy', {time: this.time.id}));
        }
    }
}
</script>

<template>
    <base-layout>
        <v-container class="mt-6">
            <user-form :user="user" :roles="roles" with-password @submit="submit">
                <template #title>
                    Création d'un utilisateur
                </template>
                <template #button>
                    Créer
                </template>
            </user-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import UserForm from "../../components/forms/UserForm";

export default {
    name: "UserCreate",
    components: {UserForm, BaseLayout},
    props: {
        roles: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            user: {},
        }
    },
    methods: {
        submit() {
            this.user._token = this.$page.csrf_token;
            return this.$inertia.post(this.route('users.store'), this.user)
        }
    }
}
</script>

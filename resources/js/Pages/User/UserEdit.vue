<template>
    <base-layout>
        <v-container class="mt-6">
            <user-form :user="user" :roles="roles" :with-password="isAuth" with-delete @submit="submit" @deleteUser="deleteUser">
                <template #title>
                    {{ title }}
                </template>
                <template #button>
                    Enregistrer
                </template>
            </user-form>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import UserForm from "../../components/forms/UserForm";

export default {
    name: "UserEdit",
    components: {UserForm, BaseLayout},
    props: {
        user: {
            required: true,
            type: Object
        },
        roles: {
            required: true,
            type: Array
        }
    },
    computed: {
        title () {
            return this.$page.auth.id === this.user.id ? "Profil" : "Édition de l'utilisateur";
        },
        isAuth () {
            return this.$page.auth.id === this.user.id;
        },
    },
    methods: {
        submit() {
            return this.$inertia.put(this.route('users.update', {user: this.isAuth ? 'me' : this.user.id }), this.user)
        },
        deleteUser() {
            return this.$inertia.delete(this.route('users.destroy', {user: this.isAuth ? 'me' : this.user.id}));
        }
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <v-row no-gutters class="mb-10">
            <v-col cols="12" class="text-center">
                <h1>
                    <slot name="title" />
                </h1>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="user.name"
                    :error-messages="nameErrors"
                    label="Nom"
                    required />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="user.email"
                    :error-messages="emailErrors"
                    label="Email"
                    required />
            </v-col>
            <v-col v-if="withPassword" cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="user.password"
                    :error-messages="passwordErrors"
                    label="Mot de passe"
                    type="password" />
            </v-col>
            <v-col v-if="withPassword" cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="user.password_confirmation"
                    :error-messages="passwordConfirmationErrors"
                    label="Confirmation"
                    type="password" />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-select
                    v-model="user.role"
                    :error-messages="roleErrors"
                    :items="roles"
                    label="Role" />
            </v-col>
            <v-col cols="12">
                <v-btn class="mr-4" color="primary" type="submit">
                    <slot name="button" />
                </v-btn>
                <v-btn v-if="withDelete" class="mr-4" color="error" @click="$emit('deleteUser')">
                    Supprimer
                </v-btn>
            </v-col>
        </v-row>
    </form>
</template>

<script>

export default {
    name: "UserForm",
    props: {
        user: {
            required: true,
            type: Object
        },
        roles: {
            required: true,
            type: Array
        },
        withPassword: {
            required: false,
            type: Boolean,
            default: false
        },
        withDelete: {
            required: false,
            type: Boolean,
            default: false
        }
    },
    computed: {
        nameErrors () {
            return this.$serverErrors('name');
        },
        emailErrors () {
            return this.$serverErrors('email');
        },
        passwordErrors () {
            return this.$serverErrors('password');
        },
        passwordConfirmationErrors () {
            return this.$serverErrors('password_confirmation');
        },
        roleErrors() {
            return this.$serverErrors('role');
        }
    },
    methods: {
        submit () {
            this.$emit('submit');
        },
    }
}
</script>

<style scoped>
    form {
        width: 100%;
    }
</style>

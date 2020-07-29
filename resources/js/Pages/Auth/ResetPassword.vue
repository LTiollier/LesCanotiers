<template>
    <auth-layout>
        <v-form ref="ResetPassword">
            <v-card-title class="headline">
                Réinitialisation du mot de passe
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="email"
                    label="Email"
                    name="email"
                    :error-messages="emailErrors"
                    prepend-icon="mdi-email"
                    disabled
                    type="text" />
                <v-text-field
                    v-model="password"
                    :error-messages="passwordErrors"
                    label="Mot de passe"
                    type="password"
                    prepend-icon="mdi-lock" />
                <v-text-field
                    v-model="password_confirmation"
                    :error-messages="passwordConfirmationErrors"
                    label="Confirmation"
                    type="password"
                    prepend-icon="mdi-lock" />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn color="primary" @click="submit">
                    Réinitialiser le mot de passe
                </v-btn>
            </v-card-actions>
        </v-form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout";

export default {
    name: "ResetPassword",
    components: {AuthLayout},
    props: {
        token: {
            type: String,
            required: true
        },
        email: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            password: '',
            password_confirmation: '',
        }
    },
    computed: {
        emailErrors () {
            return this.$serverErrors('email');
        },
        passwordErrors () {
            return this.$serverErrors('password');
        },
        passwordConfirmationErrors () {
            return this.$serverErrors('password_confirmation');
        },
    },
    methods: {
        submit() {
            return this.$inertia.post(route('password.update'), {
                token: this.token,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            })
        }
    }
}
</script>

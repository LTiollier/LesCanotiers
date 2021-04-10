<template>
    <auth-layout>
        <v-form ref="login" :action="route('login.create')" method="POST" @submit.prevent="submit">
            <v-card-title class="headline">
                Connexion
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="login.email"
                    label="Email"
                    name="email"
                    prepend-icon="mdi-email"
                    :error-messages="emailErrors"
                    type="text" />
                <v-text-field
                    id="password"
                    v-model="login.password"
                    label="Mot de passe"
                    name="password"
                    prepend-icon="mdi-lock"
                    :error-messages="passwordErrors"
                    type="password" />
                <v-checkbox
                    id="remember"
                    v-model="login.remember"
                    name="remember"
                    label="Se souvenir de moi"
                    value="1"
                    :checked="login.remember" />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn color="primary" type="submit">
                    Connexion
                </v-btn>
                <v-btn color="secondary" text @click="$inertia.visit(route('password.request'))">
                    Mot de passe oublié ?
                </v-btn>
            </v-card-actions>
        </v-form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout";

export default {
    name: "Login",
    components: {AuthLayout},
    data() {
        return {
            login: {
                email: '',
                password: '',
                remember: false
            }
        }
    },
    computed: {
        emailErrors() {
            return this.$serverErrors('email');
        },
        passwordErrors() {
            return this.$serverErrors('password');
        },
    },
    methods: {
        submit() {
            this.login._token = this.$page.csrf_token;
            this.$inertia.post(route('login.create'), this.login);
        },
    }
}
</script>

<template>
    <auth-layout>
        <v-form ref="requestReset">
            <v-card-title class="headline">
                Réinitialisation du mot de passe
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="email"
                    label="Email"
                    name="email"
                    prepend-icon="mdi-email"
                    :error-messages="emailErrors"
                    type="text" />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn color="primary" @click="submit">
                    Envoyer le lien de réinitialisation
                </v-btn>
            </v-card-actions>
        </v-form>
        <v-banner v-if="success" color="success mt-3">
            <v-icon
                slot="icon"
                color="black"
                size="36">
                mdi-check
            </v-icon>
            {{ success }}
        </v-banner>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../layouts/AuthLayout";

export default {
    name: "RequestResetPassword",
    components: {AuthLayout},
    props: {
        success: {
            type: String,
            required: false,
            default: ''
        }
    },
    data() {
        return {
            email: '',
        }
    },
    computed: {
        emailErrors() {
            return this.$serverErrors('email');
        },
    },
    methods: {
        submit() {
            this.$inertia.post(route('password.email'), {email: this.email})
        }
    }
}
</script>

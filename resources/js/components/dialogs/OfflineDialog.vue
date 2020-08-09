<template>
    <v-row justify="center">
        <v-dialog v-model="isOffline" persistent max-width="350">
            <v-card color="error">
                <v-card-title class="headline">
                    Problème de connexion !
                </v-card-title>
                <v-card-text>
                    L'application n'est pas utilisable sans une connexion internet.
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    name: "OfflineDialog",
}
</script>

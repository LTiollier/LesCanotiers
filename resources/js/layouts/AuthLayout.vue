<template>
    <v-app id="app">
        <v-content class="primary">
            <v-container
                class="fill-height"
                fluid>
                <v-row
                    align="center"
                    justify="center">
                    <v-col
                        cols="12"
                        sm="8"
                        md="6">
                        <v-card class="elevation-12">
                            <slot />
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    name: "AuthLayout"
}
</script>

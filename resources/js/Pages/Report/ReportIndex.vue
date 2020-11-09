<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Compte rendu</h1>
                </v-col>
            </v-row>
            <v-row>
                <v-data-table
                    :items-per-page="5"
                    class="elevation-1" />
            </v-row>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";

export default {
    name: "ReportIndex",
    components: {BaseLayout},
    props: {
        cycles: {
            type: Array,
            required: true
        }
    }
}
</script>

<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Ajout d'un temps</h1>
                </v-col>
            </v-row>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
export default {
    name: "TimeCreate",
    components: {BaseLayout},
    props: {
        cycles: {
            required: true,
            type: Array
        }
    }
}
</script>

<style scoped>

</style>

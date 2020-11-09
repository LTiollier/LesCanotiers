<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Compte rendu</h1>
                </v-col>
            </v-row>
            <v-row>
                <cycles-report :cycles="cycles" />
            </v-row>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import CyclesReport from "../../components/CyclesReport";

export default {
    name: "ReportIndex",
    components: {CyclesReport, BaseLayout},
    props: {
        cycles: {
            type: Array,
            required: true
        }
    }
}
</script>

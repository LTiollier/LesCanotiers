<template>
    <base-layout>
        <v-container>
            <v-row no-gutters class="mb-10">
                <v-col cols="12" class="text-center">
                    <h1>Compte rendu</h1>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6" md="4">
                    <date-input v-model="date.endsAt" label="Fin le" @change="submit" />
                </v-col>
                <v-col cols="6" md="4">
                    <date-input v-model="date.startsAt" label="À partir de" @change="submit" />
                </v-col>
                <v-col cols="6" md="2">
                    <v-btn color="primary" @click="submit">
                        Recharger
                    </v-btn>
                </v-col>
                <v-col cols="6" md="2">
                    <a :href="route('cycles.report.export', {startsAt: date.startsAt, endsAt: date.endsAt,})" target="_blank">
                        <v-btn color="green">
                            Exporter
                        </v-btn>
                    </a>
                </v-col>
            </v-row>
            <v-row class="text-center">
                <cycles-report :cycles="cycles" />
            </v-row>
        </v-container>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/BaseLayout";
import CyclesReport from "../../components/CyclesReport";
import DateInput from "../../components/inputs/DateInput";

export default {
    name: "ReportIndex",
    components: {DateInput, CyclesReport, BaseLayout},
    props: {
        cycles: {
            type: Array,
            required: true
        },
        startsAt: {
            type: String,
            required: true
        },
        endsAt: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            date: {
                startsAt: this.startsAt,
                endsAt: this.endsAt,
            }
        }
    },
    methods: {
        submit() {
            if (this.date.startsAt && this.date.endsAt) {
                this.$inertia.visit(route('report', this.date));
            }
        }
    }
}
</script>

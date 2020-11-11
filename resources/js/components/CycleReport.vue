<template>
    <v-card>
        <v-card-title>
            Compte rendu du cycle
            <v-spacer />
            <a :href="route('cycles.report', {cycle: cycle.id})" target="_blank">
                <v-btn color="green">
                    Exporter
                </v-btn>
            </a>
        </v-card-title>
        <v-card-text>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th
                                v-for="activity in activities"
                                :key="activity.id"
                                class="text-left">
                                {{ activity.name }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td
                                v-for="activity in activities"
                                :key="activity.id">
                                {{ timeConvert(activity.times) }}
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<script>
import {forEach} from 'lodash';

export default {
    name: "CycleReport",
    props: {
        cycle: {
            type: Object,
            required: true
        }
    },
    computed: {
        activities() {
            let activities = {};
            if (!this.cycle.times) return [];

            forEach(this.cycle.times, (time) => {
                if (!activities[time.activity.id]) {
                    activities[time.activity.id] = {
                        name: time.activity.name,
                        id: time.activity.id,
                        times: time.minutes
                    };
                    return;
                }

                activities[time.activity.id].times += time.minutes;
            });

            return Object.values(activities);
        },
    },
    methods: {
        timeConvert(totalMinutes) {
            if (totalMinutes < 60) {
                return totalMinutes;
            }

            let hours = (totalMinutes / 60);
            let flooredHours = Math.floor(hours);
            let minutes = (hours - flooredHours) * 60;
            let roundedMinutes = Math.round(minutes);

            return roundedMinutes ? flooredHours + "H" + roundedMinutes : flooredHours + "H";
        },
    }
}
</script>

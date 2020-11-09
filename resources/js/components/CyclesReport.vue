<template>
    <v-card>
        <v-card-text>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>
                                Fruit/Légume
                            </th>
                            <th
                                v-for="activity in activities"
                                :key="activity.id"
                                class="text-left">
                                {{ activity.name }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="cycle in activitiesByCycle"
                            :key="cycle.id"
                            class="text-left">
                            <td>
                                {{ cycle.vegetable.name }}
                            </td>
                            <td
                                v-for="activity in activities"
                                :key="activity.id">
                                {{ timeConvert(cycle.activities[activity.id].times) }}
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<script>
import {forEach, cloneDeep} from "lodash";

export default {
    name: "CyclesReport",
    props: {
        cycles: {
            type: Array,
            required: true
        }
    },
    computed: {
        activities() {
            let activities = {};

            forEach(this.cycles, (cycle) => {
                if (!cycle.times) return [];

                forEach(cycle.times, (time) => {
                    if (!activities[time.activity.id]) {
                        activities[time.activity.id] = {
                            name: time.activity.name,
                            id: time.activity.id,
                            times: 0,
                        };
                    }
                });
            });

            return activities;
        },
        activitiesByCycle() {
            let cycles = [];
            forEach(this.cycles, (cycle) => {
                let cycleWithTotalTimes = cloneDeep(cycle);
                cycleWithTotalTimes.activities = cloneDeep(this.activities);

                if (!cycle.times.length) {
                    return cycleWithTotalTimes;
                }

                forEach(cycle.times, (time) => {
                    if (
                        !cycleWithTotalTimes.activities[time.activity.id].times
                        && cycleWithTotalTimes.activities[time.activity.id].times !== 0
                    ) {
                        cycleWithTotalTimes.activities[time.activity.id].times = time.minutes;
                        return;
                    }

                    cycleWithTotalTimes.activities[time.activity.id].times += time.minutes;
                });

                cycles.push(cycleWithTotalTimes);
            });

            return cycles;
        }
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
        }
    }
}
</script>

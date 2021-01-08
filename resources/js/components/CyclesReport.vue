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
                            v-for="vegetable in cyclesReport"
                            :key="vegetable.id"
                            class="text-left">
                            <td>
                                {{ vegetable.name }}
                            </td>
                            <td
                                v-for="activity in vegetable.activities"
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

export default {
    name: "CyclesReport",
    props: {
        cyclesReport: {
            type: Object,
            required: true
        },
    },
    computed: {
        activities() {
            if (this.cyclesReport.length === 0) return [];

            return Object.values(this.cyclesReport)[0].activities;
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
        },
    }
}
</script>

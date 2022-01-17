<template>
    <v-card
        class="mx-auto">
        <v-list>
            <v-list-item-group>
                <v-virtual-scroll
                    :items="items"
                    height="300"
                    item-height="64">
                    <template v-slot:default="{ item }">
                        <v-list-item
                            @click="$emit('click', item)">
                            <v-list-item-content>
                                <v-list-item-title>
                                    <slot :item="item">
                                        {{ item.name }}
                                    </slot>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-virtual-scroll>
            </v-list-item-group>
        </v-list>
    </v-card>
</template>

<script>
export default {
    name: "ListSelector",
    props: {
        items: {
            type: Array,
            required: true
        },
        itemText: {
            type: String,
            default: 'name'
        }
    },
}
</script>

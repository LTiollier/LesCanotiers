<template>
    <v-card
        class="mx-auto">
        <v-list>
            <v-list-item-group>
                <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                    @click="$emit('click', item)">
                    <v-list-item-content>
                        <v-list-item-title>
                            <slot :item="item">
                                {{ item.name }}
                            </slot>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
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

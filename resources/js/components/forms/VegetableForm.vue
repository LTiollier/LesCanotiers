<template>
    <form @submit.prevent="submit">
        <v-row no-gutters class="mb-10">
            <v-col cols="12" class="text-center">
                <h1>
                    <slot name="title" />
                </h1>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col cols="12" md="6" class="pa-3">
                <v-text-field
                    v-model="vegetable.name"
                    :error-messages="nameErrors"
                    label="Nom"
                    required />
            </v-col>
            <v-col cols="12" md="6" class="pa-3">
                <v-select
                    v-model="vegetable.vegetable_category"
                    :items="vegetableCategories"
                    :error-messages="vegetableCategoryErrors"
                    label="Catégorie Fruit/Légume"
                    item-text="name"
                    item-value="id"
                    return-object
                    required />
            </v-col>
            <v-col cols="12">
                <v-btn class="mr-4" color="primary" type="submit">
                    <slot name="button" />
                </v-btn>
                <v-btn v-if="withDelete" class="mr-4" color="error" @click="$emit('deleteVegetable')">
                    Supprimer
                </v-btn>
            </v-col>
        </v-row>
    </form>
</template>

<script>

export default {
    name: "VegetableForm",
    props: {
        vegetable: {
            required: true,
            type: Object
        },
        withDelete: {
            required: false,
            type: Boolean,
            default: false
        },
        vegetableCategories: {
            required: true,
            type: Array,
        }
    },
    computed: {
        nameErrors () {
            return this.$serverErrors('name');
        },
        vegetableCategoryErrors() {
            return this.$serverErrors('vegetable_category');
        }
    },
    methods: {
        submit () {
            this.$emit('submit');
        },
    }
}
</script>

<style scoped>
    form {
        width: 100%;
    }
</style>

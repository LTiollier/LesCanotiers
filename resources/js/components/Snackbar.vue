<template>
    <v-snackbar
        v-model="show"
        :color="type"
        top
        right
        :timeout="3000">
        {{ message }}
        <v-btn
            text
            color="white"
            dusk="button-snackbar-global-close"
            @click.native="show = false">
            Fermer
        </v-btn>
    </v-snackbar>
</template>

<script>
export default {
    data () {
        return {
            show: false,
            message: '',
            type: '',
        }
    },
    computed: {
        trigger: function() {
            return this.$store.state.snackbar.snackbar.trigger;
        },
    },
    watch: {
        trigger: function() {
            let snackbar = this.$store.getters.getFirstSnackbar;
            if (snackbar && snackbar.message) {
                this.message = snackbar.message;
                this.type = snackbar.type;
                this.show = true;
                setTimeout(() => { this.$store.commit('shiftQueue'); }, 3100);
            }
        }
    },
}
</script>

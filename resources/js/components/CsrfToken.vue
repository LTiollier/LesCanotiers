<template>
    <input type="hidden" :value="csrf" name="_token">
</template>

<script>
export default {
    name: "CsrfToken",
    computed: {
        csrf() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token ? token.content : '';
        }
    }
}
</script>

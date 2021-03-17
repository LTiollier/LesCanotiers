<template>
    <input type="hidden" :value="csrf" name="_token">
</template>

<script>
export default {
    name: "CsrfToken",
    computed: {
        csrf() {
            return getCookie('CSRF-TOKEN');
        }
    }
}
</script>

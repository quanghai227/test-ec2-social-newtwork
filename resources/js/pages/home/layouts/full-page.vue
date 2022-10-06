<template>
    <div class="__app_social_network__full_page">
        <router-view :key="$route.fullPath" />
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    created() {
        // console.log(this.$route.fullPath);
    },
    methods: {
    },
    computed: {
    }
}
</script>


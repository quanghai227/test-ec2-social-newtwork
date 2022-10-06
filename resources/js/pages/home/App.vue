<template>
  <div class="___app">
    <Loading />

    <component :is="layout">
      <router-view :key="$route.name"></router-view>
    </component>
  </div>
</template>
<script>
import Loading from '@/components/common/Loading.vue'
export default {
  name: 'App',
  data() {
    return {
      
    }
  },
  created() {
    
  },
  computed: {
    layout() {
      return `${this.$route.meta.layout || 'default'}`
    },
  },
  components: {
    Loading,
    'default': () => import('@/pages/home/layouts/main.vue'),
    'full-page': () => import('@/pages/home/layouts/full-page.vue'),
    'error-page': () => import('@/pages/home/layouts/Notfound.vue')
  },
}
</script>

<template>
  <AppHeader />
  <main class="app-main" id="main-content">
    <RouterView />
  </main>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import AppHeader from '@/components/layout/AppHeader.vue'
import { useFeedStore } from '@/stores/feedStore'

const feedStore = useFeedStore()
onMounted(() => feedStore.fetchFeeds())
</script>

<style>
/* One column, centred. Pages build any grid inside it. */
.app-main {
  max-width: 60rem;
  margin: 0 auto;
  padding: var(--space-lg);
}
</style>

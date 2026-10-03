<template>
  <div class="search-view">
    <div class="search-header">
      <h1 class="search-title">Search Results</h1>
      <p class="search-query" v-if="query">
        Showing results for <strong>"{{ query }}"</strong>
        — {{ feedStore.filtered.length }} events found
      </p>
    </div>
    <FeedGrid />
  </div>
</template>

<script setup lang="ts">
import { computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useFeedStore } from '@/stores/feedStore'
import FeedGrid from '@/components/feed/FeedGrid.vue'

const route = useRoute()
const feedStore = useFeedStore()

const query = computed(() => String(route.query.q || ''))

watch(query, (val) => {
  feedStore.setFilter({ query: val })
}, { immediate: true })
</script>

<style scoped>
.search-view { padding: 24px; display: flex; flex-direction: column; gap: 20px; }
.search-header { }
.search-title { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
.search-query { font-size: 13px; color: var(--text-secondary); }
.search-query strong { color: var(--text-primary); }
</style>

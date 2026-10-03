<template>
  <div class="news-tab">
    <div class="news-sources">
      <button v-for="name in newsSources" :key="name" class="chip" @click="toggleSource(name)"
        :class="{ active: activeSource === name }">
        {{ name }}
      </button>
    </div>
    <FeedGrid :area-id="areaId" :override-categories="['news']" :source="activeSource ?? undefined" hide-filter />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
const activeSource = ref<string | null>(null)
// names must match FeedEvent.source (src/services/rssCollector.ts)
const newsSources = ['Bloomberg Technology', 'Finextra', 'Hacker News', 'FRED Blog', 'CoinDesk']
function toggleSource(name: string) { activeSource.value = activeSource.value === name ? null : name }
</script>

<style scoped>
.news-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.news-sources { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

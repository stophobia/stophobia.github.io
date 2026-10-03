<template>
  <div class="news-tab">
    <div class="news-sources">
      <div v-for="src in newsSources" :key="src.name" class="news-source-chip" @click="toggleSource(src.name)"
        :class="{ active: activeSource === src.name }">
        {{ src.icon }} {{ src.name }}
      </div>
    </div>
    <FeedGrid :area-id="areaId" hide-filter />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
const activeSource = ref<string | null>(null)
const newsSources = [
  { name: 'Bloomberg', icon: '📊' }, { name: 'Reuters', icon: '📰' },
  { name: 'Finextra', icon: '💳' }, { name: 'Hacker News', icon: '🔶' },
]
function toggleSource(name: string) { activeSource.value = activeSource.value === name ? null : name }
</script>

<style scoped>
.news-tab { display: flex; flex-direction: column; gap: 16px; }
.news-sources { display: flex; gap: 8px; flex-wrap: wrap; }
.news-source-chip {
  padding: 5px 12px; border-radius: 100px; font-size: 12px; font-weight: 500;
  color: var(--text-muted); border: 1px solid var(--border-subtle); background: var(--bg-elevated);
  cursor: pointer; transition: all var(--transition-fast);
}
.news-source-chip:hover { color: var(--text-primary); border-color: var(--border-default); }
.news-source-chip.active { color: white; background: var(--accent-ai); border-color: var(--accent-ai); }
</style>

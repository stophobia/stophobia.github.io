<template>
  <!-- A wrapper, so AreaView's override-categories can't fall through onto FeedGrid -->
  <div>
    <FeedGrid :area-id="areaId" :override-categories="['news']" :source="activeSource ?? undefined">
      <div class="filter-group">
        <button v-for="name in newsSources" :key="name" class="chip" @click="toggleSource(name)"
          :class="{ active: activeSource === name }">
          {{ name }}
        </button>
      </div>
      <div class="filter-sep"></div>
    </FeedGrid>
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

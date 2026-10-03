<template>
  <div class="category-tab">
    <div class="category-tab-header">
      <h2 class="category-tab-title">📄 Research Papers</h2>
      <p class="category-tab-desc">Latest preprints and papers from arXiv, SSRN, NeurIPS, ICML, and more.</p>
    </div>
    <FeedGrid :area-id="areaId" :override-categories="['paper']" hide-filter />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 16px; }
.category-tab-header { }
.category-tab-title { font-size: 18px; font-weight: 700; margin-bottom: 6px; }
.category-tab-desc { font-size: 13px; color: var(--text-muted); }
</style>

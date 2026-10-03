<template>
  <div class="category-tab">
    <div>
      <h2 class="section-title">Research Papers</h2>
      <p class="muted">Latest preprints and papers from arXiv, SSRN, NeurIPS, ICML, and more.</p>
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
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
</style>

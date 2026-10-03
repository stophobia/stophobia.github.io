<template>
  <div class="strategies-tab">
    <FeedGrid :area-id="areaId" :override-categories="['strategy']" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
</script>

<style scoped>
.strategies-tab {
  display: flex;
  flex-direction: column;
}
</style>

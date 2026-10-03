<template>
  <div class="jobs-tab">
    <FeedGrid :area-id="areaId" :override-categories="['job']" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
</script>

<style scoped>
.jobs-tab {
  display: flex;
  flex-direction: column;
}
</style>

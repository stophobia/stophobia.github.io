<template>
  <div class="tools-tab">
    <FeedGrid :area-id="areaId" :override-categories="['tool']" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
</script>

<style scoped>
.tools-tab {
  display: flex;
  flex-direction: column;
}
</style>

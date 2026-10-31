<template>
  <!-- A wrapper, so AreaView's override-categories can't fall through onto FeedGrid -->
  <div>
    <FeedGrid :area-id="areaId" :override-categories="['news']" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()
</script>

<template>
  <FeedGrid :area-id="areaId" :override-categories="overrideCategories" />
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId, EventCategory } from '@/types'
defineProps<{ areaId: AreaId; overrideCategories?: EventCategory[] }>()
</script>

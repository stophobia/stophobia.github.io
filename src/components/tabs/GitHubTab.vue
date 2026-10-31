<template>
  <div class="github-tab">
    <!-- The sub-tabs lead FeedGrid's filter bar, beside its search -->
    <FeedGrid
      :area-id="active.id === 'releases' ? areaId : undefined"
      :override-categories="active.categories"
      :source="active.source"
    >
      <div class="filter-group" role="tablist">
        <button
          v-for="sub in subTabs"
          :key="sub.id"
          class="chip"
          role="tab"
          :aria-selected="active === sub"
          :class="{ active: active === sub }"
          @click="active = sub"
        >
          <span class="material-symbols-outlined" aria-hidden="true">{{ sub.icon }}</span>
          {{ sub.label }}
        </button>
      </div>
    </FeedGrid>
  </div>
</template>

<script setup lang="ts">
import { shallowRef } from 'vue'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'

defineProps<{ areaId: AreaId }>()

const subTabs = [
  // Trending isn't narrowed to the area: its one GitHub search spans AI and quant repos
  { id: 'trending', icon: 'local_fire_department', label: 'Trending Repos', source: 'GitHub Trending' },
  { id: 'releases', icon: 'sell', label: 'Releases', categories: ['github_release' as const] },
]
const active = shallowRef(subTabs[0])
</script>

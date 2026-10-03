<template>
  <div class="feed-grid-wrap">
    <!-- Filter bar -->
    <div v-if="!hideFilter" class="filter-bar card">
      <!-- Time range -->
      <div class="filter-group">
        <button
          v-for="t in timeRanges"
          :key="t.value"
          class="chip"
          :class="{ active: feedStore.filter.timeRange === t.value }"
          @click="feedStore.setFilter({ timeRange: t.value })"
        >
          {{ t.label }}
        </button>
      </div>

      <div class="filter-sep"></div>

      <!-- Sort -->
      <div class="filter-group">
        <button
          v-for="s in sortModes"
          :key="s.value"
          class="chip"
          :class="{ active: feedStore.sortMode === s.value }"
          @click="feedStore.setSortMode(s.value)"
        >
          <span class="material-symbols-outlined" aria-hidden="true">{{ s.icon }}</span>
          {{ s.label }}
        </button>
      </div>

      <div class="filter-sep"></div>

      <!-- Topics -->
      <div class="filter-group">
        <button
          v-for="t in topics"
          :key="t"
          class="chip"
          :class="{ active: feedStore.filter.tags.includes(t) }"
          @click="toggleTopic(t)"
        >
          {{ t }}
        </button>
      </div>

      <!-- Result count -->
      <span class="filter-count">{{ baseEvents.length }} results</span>
    </div>

    <p v-if="feedStore.isLoading" class="empty">Loading…</p>

    <p v-else-if="feedStore.error && displayEvents.length === 0" class="notice" role="status">
      Failed to load feeds. <button class="retry" @click="feedStore.fetchFeeds()">Retry</button>
    </p>

    <div v-else-if="displayEvents.length === 0" class="empty">
      <span class="material-symbols-outlined empty-icon" aria-hidden="true">inbox</span>
      <p>No events match your filters.</p>
      <button class="btn btn-ghost" @click="feedStore.setFilter({ timeRange: 'all', categories: [], tags: [], query: '' })">
        Clear filters
      </button>
    </div>

    <!-- Feed grid -->
    <div v-else class="card-grid">
      <EventCard
        v-for="event in displayEvents"
        :key="event.id"
        :event="event"
      />
    </div>

    <!-- Load more -->
    <div v-if="hasMore" class="load-more-wrap">
      <button class="btn btn-ghost" @click="showMore">
        Load more <span class="muted">{{ remaining }} remaining</span>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useFeedStore, TOPICS } from '@/stores/feedStore'
import EventCard from './EventCard.vue'
import type { AreaId } from '@/types'

const props = defineProps<{
  areaId?: AreaId
  overrideCategories?: import('@/types').EventCategory[]
  source?: string
  hideFilter?: boolean
}>()

const feedStore = useFeedStore()
const PAGE_SIZE = 24
const page = ref(1)

const timeRanges = [
  { value: 'today' as const, label: 'Today' },
  { value: 'week' as const, label: 'This Week' },
  { value: 'month' as const, label: 'This Month' },
  { value: 'all' as const, label: 'All Time' },
]

const sortModes = [
  { value: 'latest' as const, label: 'Latest', icon: 'schedule' },
  { value: 'score' as const, label: 'Top', icon: 'star' },
]

const baseEvents = computed(() => {
  let result = feedStore.filtered
  if (props.areaId) {
    result = result.filter((e) => e.area.includes(props.areaId!))
  }
  if (props.overrideCategories?.length) {
    result = result.filter((e) => props.overrideCategories!.includes(e.category))
  }
  if (props.source) {
    result = result.filter((e) => e.source === props.source)
  }
  return result
})

const displayEvents = computed(() => baseEvents.value.slice(0, page.value * PAGE_SIZE))
const hasMore = computed(() => displayEvents.value.length < baseEvents.value.length)
const remaining = computed(() => baseEvents.value.length - displayEvents.value.length)

function showMore() { page.value++ }

const topics = Object.keys(TOPICS)
function toggleTopic(t: string) {
  const tags = feedStore.filter.tags
  feedStore.setFilter({ tags: tags.includes(t) ? tags.filter((x) => x !== t) : [...tags, t] })
}
</script>

<style scoped>
.feed-grid-wrap {
  display: flex;
  flex-direction: column;
  gap: var(--space-md);
}

.filter-bar {
  display: flex;
  align-items: center;
  gap: var(--space-xs);
  padding: var(--space-xs) var(--space-sm);
  flex-wrap: wrap;
  position: sticky;
  top: var(--space-xs);
  z-index: 10;
}

.filter-group {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3xs);
}

.filter-sep {
  width: 1px;
  height: 1.25rem;
  background: var(--border);
}

.filter-count {
  margin-left: auto;
  font-size: var(--text-xs);
  color: var(--ink-muted);
  font-variant-numeric: tabular-nums;
}

.empty-icon { font-size: var(--text-xl); }

.retry {
  font-weight: var(--weight-medium);
  text-decoration: underline;
}

.load-more-wrap {
  display: flex;
  justify-content: center;
}
</style>

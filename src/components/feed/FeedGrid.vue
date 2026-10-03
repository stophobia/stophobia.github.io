<template>
  <div class="feed-grid-wrap">
    <!-- Filter bar -->
    <div v-if="!hideFilter" class="filter-bar glass">
      <!-- Time range -->
      <div class="filter-group">
        <button
          v-for="t in timeRanges"
          :key="t.value"
          class="filter-btn"
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
          class="filter-btn"
          :class="{ active: feedStore.sortMode === s.value }"
          @click="feedStore.setSortMode(s.value)"
        >
          {{ s.label }}
        </button>
      </div>

      <!-- Result count -->
      <span class="filter-count">{{ displayEvents.length }} results</span>
    </div>

    <!-- Loading state -->
    <div v-if="feedStore.isLoading" class="feed-loading">
      <div class="loading-grid">
        <div v-for="n in 8" :key="n" class="skeleton-card">
          <div class="skeleton" style="height:14px; width: 60%; margin-bottom: 8px"></div>
          <div class="skeleton" style="height:18px; width: 95%; margin-bottom: 6px"></div>
          <div class="skeleton" style="height:18px; width: 80%; margin-bottom: 12px"></div>
          <div class="skeleton" style="height:12px; width: 45%"></div>
        </div>
      </div>
    </div>

    <!-- Error state -->
    <div v-else-if="feedStore.error && displayEvents.length === 0" class="feed-empty">
      <span class="feed-empty-icon">⚠️</span>
      <p>Failed to load feeds. <button class="btn-link" @click="feedStore.fetchFeeds(true)">Retry</button></p>
    </div>

    <!-- Empty state -->
    <div v-else-if="displayEvents.length === 0" class="feed-empty">
      <span class="feed-empty-icon">📭</span>
      <p>No events match your filters.</p>
      <button class="btn btn-ghost" @click="feedStore.setFilter({ timeRange: 'all', categories: [], tags: [], query: '' })">
        Clear filters
      </button>
    </div>

    <!-- Feed grid -->
    <div v-else class="feed-grid">
      <EventCard
        v-for="event in displayEvents"
        :key="event.id"
        :event="event"
      />
    </div>

    <!-- Load more -->
    <div v-if="hasMore" class="load-more-wrap">
      <button class="btn btn-ghost load-more-btn" @click="showMore">
        Load more <span class="load-more-count">{{ remaining }} remaining</span>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useFeedStore } from '@/stores/feedStore'
import EventCard from './EventCard.vue'
import type { AreaId } from '@/types'

const props = defineProps<{
  areaId?: AreaId
  overrideCategories?: import('@/types').EventCategory[]
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
  { value: 'latest' as const, label: '⏱ Latest' },
  { value: 'trending' as const, label: '🔥 Trending' },
  { value: 'score' as const, label: '⭐ Top' },
]

const baseEvents = computed(() => {
  let result = feedStore.filtered
  if (props.areaId) {
    result = result.filter((e) => e.area.includes(props.areaId!))
  }
  if (props.overrideCategories?.length) {
    result = result.filter((e) => props.overrideCategories!.includes(e.category))
  }
  return result
})

const displayEvents = computed(() => baseEvents.value.slice(0, page.value * PAGE_SIZE))
const hasMore = computed(() => displayEvents.value.length < baseEvents.value.length)
const remaining = computed(() => baseEvents.value.length - displayEvents.value.length)

function showMore() { page.value++ }
</script>

<style scoped>
.feed-grid-wrap {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* Filter bar */
.filter-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 16px;
  border-radius: var(--radius-md);
  flex-wrap: wrap;
  position: sticky;
  top: 8px;
  z-index: 10;
}

.filter-group {
  display: flex;
  gap: 4px;
}

.filter-btn {
  padding: 5px 12px;
  border-radius: var(--radius-sm);
  font-size: 12px;
  font-weight: 500;
  color: var(--text-muted);
  border: 1px solid transparent;
  transition: all var(--transition-fast);
}

.filter-btn:hover {
  color: var(--text-secondary);
  background: var(--bg-hover);
}

.filter-btn.active {
  color: var(--text-primary);
  background: var(--bg-overlay);
  border-color: var(--border-default);
}

.filter-sep {
  width: 1px;
  height: 20px;
  background: var(--border-subtle);
  margin: 0 4px;
}

.filter-count {
  margin-left: auto;
  font-size: 12px;
  color: var(--text-muted);
  font-variant-numeric: tabular-nums;
}

/* Grid */
.feed-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 14px;
}

@media (max-width: 640px) {
  .feed-grid {
    grid-template-columns: 1fr;
  }
}

/* Loading */
.loading-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 14px;
}

.skeleton-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 16px;
}

/* Empty / Error */
.feed-empty {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  padding: 60px 20px;
  text-align: center;
  color: var(--text-secondary);
}

.feed-empty-icon { font-size: 40px; }

.btn-link {
  color: var(--accent-ai);
  font-weight: 500;
  text-decoration: underline;
  cursor: pointer;
}

/* Load more */
.load-more-wrap {
  display: flex;
  justify-content: center;
  padding: 12px 0;
}

.load-more-btn {
  gap: 8px;
}

.load-more-count {
  font-size: 11px;
  color: var(--text-muted);
}
</style>

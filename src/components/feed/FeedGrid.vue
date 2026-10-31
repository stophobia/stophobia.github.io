<template>
  <div class="feed-grid-wrap">
    <!-- A tab's own tabs lead the bar, through the slot -->
    <FilterBar v-model="query" :count="baseEvents.length" placeholder="Search title, source, author…">
      <template #tabs><slot /></template>

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
      <div class="topics">
        <AppScroller class="topic-scroller">
          <div class="filter-group">
            <button
              v-for="t in feedStore.topics"
              :key="t"
              class="chip"
              :class="{ active: feedStore.filter.tags.includes(t) }"
              @click="toggleTopic(t)"
            >
              {{ t }}
            </button>
          </div>
        </AppScroller>
        <button class="btn-icon" title="Edit topics" aria-label="Edit topics" @click="openTopics">
          <span class="material-symbols-outlined" aria-hidden="true">edit</span>
        </button>
      </div>
    </FilterBar>

    <ChannelGrid v-if="shownChannels?.length" :channels="shownChannels" />

    <p v-if="feedStore.isLoading" class="empty">Loading…</p>

    <p v-else-if="feedStore.error && displayEvents.length === 0" class="notice" role="status">
      Failed to load feeds. <button class="retry" @click="feedStore.fetchFeeds()">Retry</button>
    </p>

    <div v-else-if="displayEvents.length === 0" class="empty">
      <span class="material-symbols-outlined empty-icon" aria-hidden="true">inbox</span>
      <p>No events match your filters.</p>
      <button class="btn btn-ghost" @click="query = ''; feedStore.setFilter({ timeRange: 'all', categories: [], tags: [], query: '' })">
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

    <dialog ref="topicDialog" class="dialog card" aria-labelledby="topics-title" closedby="any">
      <form class="dialog-form" @submit.prevent="saveTopics">
        <h2 id="topics-title" class="dialog-title">Edit topics</h2>
        <label class="field">
          One topic per line
          <textarea v-model="draft" class="input" rows="8"></textarea>
        </label>
        <p class="muted">Applied from the next update.</p>
        <div class="dialog-actions">
          <button type="button" class="btn btn-ghost dialog-aside" @click="draft = Object.keys(TOPICS).join('\n')">
            <span class="material-symbols-outlined" aria-hidden="true">refresh</span> Defaults
          </button>
          <button type="button" class="btn btn-ghost" @click="topicDialog?.close()">
            <span class="material-symbols-outlined" aria-hidden="true">close</span> Cancel
          </button>
          <button class="btn btn-primary">
            <span class="material-symbols-outlined" aria-hidden="true">check</span> Save
          </button>
        </div>
      </form>
    </dialog>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useFeedStore, TOPICS, matches, eventFields } from '@/stores/feedStore'
import AppScroller from '@/components/layout/AppScroller.vue'
import FilterBar from '@/components/layout/FilterBar.vue'
import EventCard from './EventCard.vue'
import ChannelGrid from './ChannelGrid.vue'
import type { AreaId, Channel } from '@/types'

const props = defineProps<{
  areaId?: AreaId
  overrideCategories?: import('@/types').EventCategory[]
  source?: string
  channels?: Channel[] // sites to follow, shown above the events
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

// This tab's search; the header's search is the store's query
const query = ref('')

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
  if (query.value.trim()) {
    result = result.filter((e) => matches(query.value, eventFields(e)))
  }
  return result
})

const shownChannels = computed(() => props.channels?.filter((c) => matches(query.value, [c.name, c.desc, c.area])))

const displayEvents = computed(() => baseEvents.value.slice(0, page.value * PAGE_SIZE))
const hasMore = computed(() => displayEvents.value.length < baseEvents.value.length)
const remaining = computed(() => baseEvents.value.length - displayEvents.value.length)

function showMore() { page.value++ }

function toggleTopic(t: string) {
  const tags = feedStore.filter.tags
  feedStore.setFilter({ tags: tags.includes(t) ? tags.filter((x) => x !== t) : [...tags, t] })
}

const topicDialog = ref<HTMLDialogElement>()
const draft = ref('')

function openTopics() {
  draft.value = feedStore.savedTopics.join('\n')
  topicDialog.value?.showModal()
}

function saveTopics() {
  feedStore.saveTopics([...new Set(draft.value.split('\n').map((t) => t.trim()).filter(Boolean))])
  topicDialog.value?.close()
}
</script>

<style scoped>
.feed-grid-wrap {
  display: flex;
  flex-direction: column;
  gap: var(--space-md);
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

/* The topics take the rest of their row and scroll between arrows once they outgrow it */
.topics {
  display: flex;
  align-items: center;
  flex: 1 1 14rem;
  min-width: 0;
}

.topic-scroller { flex: 1; }
</style>

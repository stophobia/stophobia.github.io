<template>
  <div class="area-view" v-if="area">
    <header class="area-header">
      <div>
        <h1 class="page-title">{{ area.label }}</h1>
        <p class="muted">{{ area.description }}</p>
      </div>
      <span class="muted">{{ areaEventCount }} events</span>
    </header>

    <nav class="tab-nav" role="tablist">
      <RouterLink
        v-for="tabId in area.tabs"
        :key="tabId"
        :to="`/area/${area.id}/${tabId}`"
        class="chip"
        role="tab"
        :id="`tab-${tabId}`"
      >
        <span class="material-symbols-outlined" aria-hidden="true">{{ TABS[tabId]?.icon }}</span>
        {{ TABS[tabId]?.label }}
      </RouterLink>
    </nav>

    <div role="tabpanel">
      <component
        :is="tabComponent"
        :key="currentTab"
        :area-id="areaId"
        :area="area"
        :override-categories="TAB_CATEGORIES[currentTab]"
      />
    </div>
  </div>

  <p v-else class="empty">Area not found.</p>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { AREAS, TABS } from '@/data/areas'
import { useFeedStore } from '@/stores/feedStore'
import type { AreaId, EventCategory, TabId } from '@/types'

// Tab components
import FeedTab from '@/components/tabs/FeedTab.vue'
import PeopleTab from '@/components/tabs/PeopleTab.vue'
import OrganizationsTab from '@/components/tabs/OrganizationsTab.vue'
import PapersTab from '@/components/tabs/PapersTab.vue'
import GitHubTab from '@/components/tabs/GitHubTab.vue'
import NewsTab from '@/components/tabs/NewsTab.vue'
import BlogTab from '@/components/tabs/BlogTab.vue'
import VideosTab from '@/components/tabs/VideosTab.vue'
import PodcastsTab from '@/components/tabs/PodcastsTab.vue'
import DatasetsTab from '@/components/tabs/DatasetsTab.vue'
import ConferencesTab from '@/components/tabs/ConferencesTab.vue'

const props = defineProps<{
  areaId: AreaId
  tabId?: TabId
}>()

const feedStore = useFeedStore()
const area = computed(() => AREAS.find((a) => a.id === props.areaId) || null)
const currentTab = computed(() => props.tabId || area.value?.tabs[0] || 'feed')

const areaEventCount = computed(() => {
  return feedStore.byArea[props.areaId]?.length ?? 0
})

const TAB_COMPONENTS: Record<string, object> = {
  feed: FeedTab,
  people: PeopleTab,
  organizations: OrganizationsTab,
  papers: PapersTab,
  github: GitHubTab,
  news: NewsTab,
  blog: BlogTab,
  videos: VideosTab,
  podcasts: PodcastsTab,
  datasets: DatasetsTab,
  conferences: ConferencesTab,
}

// Tabs without their own component render FeedTab narrowed to these categories
const TAB_CATEGORIES: Partial<Record<TabId, EventCategory[]>> = {
  jobs: ['job'],
  strategies: ['strategy'],
  tools: ['tool'],
  regulation: ['regulation'],
}

const tabComponent = computed(() => TAB_COMPONENTS[currentTab.value] || FeedTab)
</script>

<style scoped>
.area-view { display: flex; flex-direction: column; gap: var(--space-md); }

.area-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: var(--space-md);
  flex-wrap: wrap;
}

.tab-nav {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2xs);
  padding-bottom: var(--space-sm);
  border-bottom: 1px solid var(--border);
}
</style>

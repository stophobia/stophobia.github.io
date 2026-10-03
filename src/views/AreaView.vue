<template>
  <div class="area-view" v-if="area">
    <!-- Area Hero Header -->
    <div class="area-hero" :style="{ '--area-gradient': area.gradient, '--area-color': area.color }">
      <div class="area-hero-inner">
        <div class="area-hero-icon">{{ area.icon }}</div>
        <div class="area-hero-text">
          <h1 class="area-hero-title">{{ area.label }}</h1>
          <p class="area-hero-desc">{{ area.description }}</p>
        </div>
        <div class="area-hero-stat">
          <span class="area-stat-num">{{ areaEventCount }}</span>
          <span class="area-stat-label">events</span>
        </div>
      </div>

      <!-- Tab navigation -->
      <div class="tab-nav" role="tablist">
        <RouterLink
          v-for="tabId in area.tabs"
          :key="tabId"
          :to="`/area/${area.id}/${tabId}`"
          class="tab-item"
          :class="{ active: currentTab === tabId }"
          role="tab"
          :id="`tab-${tabId}`"
        >
          <span class="tab-icon">{{ TABS[tabId]?.icon }}</span>
          <span class="tab-label">{{ TABS[tabId]?.label }}</span>
        </RouterLink>
      </div>
    </div>

    <!-- Tab content -->
    <div class="area-content" role="tabpanel">
      <Transition name="fade" mode="out-in">
        <component
          :is="tabComponent"
          :key="currentTab"
          :area-id="areaId"
          :area="area"
        />
      </Transition>
    </div>
  </div>

  <div v-else class="area-not-found">
    <p>Area not found.</p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { AREAS, TABS } from '@/data/areas'
import { useFeedStore } from '@/stores/feedStore'
import type { AreaId, TabId } from '@/types'

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

const tabComponent = computed(() => TAB_COMPONENTS[currentTab.value] || FeedTab)
</script>

<style scoped>
.area-view {
  display: flex;
  flex-direction: column;
  min-height: 100%;
}

/* Hero */
.area-hero {
  background: linear-gradient(
    180deg,
    color-mix(in srgb, var(--area-color) 12%, var(--bg-surface)) 0%,
    var(--bg-base) 100%
  );
  border-bottom: 1px solid var(--border-subtle);
  position: relative;
  overflow: hidden;
}

.area-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, color-mix(in srgb, var(--area-color) 10%, transparent), transparent 70%);
  pointer-events: none;
}

.area-hero-inner {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 24px 24px 0;
}

.area-hero-icon {
  font-size: 36px;
  flex-shrink: 0;
  filter: drop-shadow(0 0 12px var(--area-color));
}

.area-hero-text { flex: 1; }

.area-hero-title {
  font-size: clamp(1.2rem, 3vw, 1.6rem);
  font-weight: 800;
  letter-spacing: -0.02em;
  color: var(--text-primary);
}

.area-hero-desc {
  font-size: 13px;
  color: var(--text-secondary);
  margin-top: 4px;
}

.area-hero-stat {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  flex-shrink: 0;
}

.area-stat-num {
  font-size: 24px;
  font-weight: 800;
  color: var(--area-color);
  font-variant-numeric: tabular-nums;
  line-height: 1;
}

.area-stat-label {
  font-size: 11px;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Tab nav */
.tab-nav {
  display: flex;
  gap: 0;
  padding: 16px 16px 0;
  overflow-x: auto;
  scrollbar-width: none;
}
.tab-nav::-webkit-scrollbar { display: none; }

.tab-item {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  font-size: 13px;
  font-weight: 500;
  color: var(--text-muted);
  border-bottom: 2px solid transparent;
  transition: all var(--transition-fast);
  white-space: nowrap;
  flex-shrink: 0;
}

.tab-item:hover {
  color: var(--text-secondary);
  border-bottom-color: var(--border-default);
}

.tab-item.active {
  color: var(--area-color);
  border-bottom-color: var(--area-color);
}

.tab-icon { font-size: 14px; }

/* Content */
.area-content {
  flex: 1;
  padding: 20px;
}

.area-not-found {
  padding: 60px;
  text-align: center;
  color: var(--text-muted);
}
</style>

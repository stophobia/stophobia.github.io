<template>
  <nav class="side-nav glass">
    <div class="nav-sections">
      <div v-for="area in areas" :key="area.id" class="nav-area-group">
        <RouterLink
          :to="`/area/${area.id}/${area.tabs[0]}`"
          class="nav-area-item"
          :class="{ active: currentArea === area.id }"
          :style="currentArea === area.id ? { '--area-color': area.color } : {}"
        >
          <span class="nav-area-icon">{{ area.icon }}</span>
          <span class="nav-area-label">{{ area.label }}</span>
          <span class="nav-area-arrow" v-if="currentArea === area.id">›</span>
        </RouterLink>

        <!-- Sub-tabs when area is active -->
        <Transition name="expand">
          <div v-if="currentArea === area.id" class="nav-tabs">
            <RouterLink
              v-for="tabId in area.tabs"
              :key="tabId"
              :to="`/area/${area.id}/${tabId}`"
              class="nav-tab-item"
              :class="{ active: currentTab === tabId }"
            >
              <span class="nav-tab-icon">{{ TABS[tabId]?.icon }}</span>
              <span class="nav-tab-label">{{ TABS[tabId]?.label }}</span>
            </RouterLink>
          </div>
        </Transition>
      </div>
    </div>

    <!-- Bottom stats -->
    <div class="nav-footer">
      <div class="nav-stat">
        <span class="nav-stat-value">{{ feedStore.events.length }}</span>
        <span class="nav-stat-label">Events</span>
      </div>
      <div class="nav-stat-divider"></div>
      <div class="nav-stat">
        <span class="nav-stat-value">{{ lastUpdated }}</span>
        <span class="nav-stat-label">Updated</span>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { AREAS, TABS } from '@/data/areas'
import { useFeedStore } from '@/stores/feedStore'

const route = useRoute()
const feedStore = useFeedStore()
const areas = AREAS

const currentArea = computed(() => route.params.areaId as string)
const currentTab = computed(() => route.params.tabId as string)

const lastUpdated = computed(() => {
  if (!feedStore.lastFetchedAt) return '—'
  const diff = Date.now() - feedStore.lastFetchedAt
  if (diff < 60000) return 'Just now'
  if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`
  return `${Math.floor(diff / 3600000)}h ago`
})
</script>

<style scoped>
.side-nav {
  width: var(--nav-width);
  min-width: var(--nav-width);
  height: calc(100dvh - var(--header-height));
  border-right: 1px solid var(--border-subtle);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  position: sticky;
  top: var(--header-height);
}

@media (max-width: 900px) {
  .side-nav { display: none; } /* MobileNav takes over (App.vue) */
}

.nav-sections {
  flex: 1;
  padding: 8px 0;
}

.nav-area-group { margin-bottom: 2px; }

.nav-area-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 16px;
  font-size: 13px;
  font-weight: 500;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all var(--transition-fast);
  position: relative;
}

.nav-area-item:hover {
  color: var(--text-primary);
  background: var(--bg-hover);
}

.nav-area-item.active {
  color: var(--area-color, var(--accent-ai));
  background: rgba(255, 255, 255, 0.04);
}

.nav-area-item.active::before {
  content: '';
  position: absolute;
  left: 0;
  top: 6px;
  bottom: 6px;
  width: 3px;
  background: var(--area-color, var(--accent-ai));
  border-radius: 0 3px 3px 0;
}

.nav-area-icon { font-size: 16px; flex-shrink: 0; }
.nav-area-label { flex: 1; }
.nav-area-arrow { font-size: 16px; opacity: 0.6; }

/* Tabs */
.nav-tabs {
  padding: 2px 0 6px;
  overflow: hidden;
}

.nav-tab-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 16px 6px 36px;
  font-size: 12px;
  font-weight: 400;
  color: var(--text-muted);
  cursor: pointer;
  transition: all var(--transition-fast);
}

.nav-tab-item:hover {
  color: var(--text-secondary);
  background: rgba(255, 255, 255, 0.02);
}

.nav-tab-item.active {
  color: var(--text-primary);
  font-weight: 500;
}

.nav-tab-icon { font-size: 13px; }
.nav-tab-label { }

/* Expand animation */
.expand-enter-active,
.expand-leave-active {
  transition: max-height var(--transition-base), opacity var(--transition-fast);
  max-height: 500px;
  overflow: hidden;
}
.expand-enter-from,
.expand-leave-to {
  max-height: 0;
  opacity: 0;
}

/* Footer */
.nav-footer {
  padding: 12px 16px;
  border-top: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  gap: 12px;
}

.nav-stat {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.nav-stat-value {
  font-size: 14px;
  font-weight: 700;
  color: var(--text-primary);
  font-variant-numeric: tabular-nums;
}

.nav-stat-label {
  font-size: 10px;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.nav-stat-divider {
  width: 1px;
  height: 28px;
  background: var(--border-subtle);
}
</style>

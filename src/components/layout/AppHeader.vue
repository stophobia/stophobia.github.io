<template>
  <header class="app-bar">
    <RouterLink to="/" class="brand">
      <span class="brand-mark">F</span>
      <span>FAIH</span>
    </RouterLink>

    <!-- Areas: the menu -->
    <nav class="area-nav">
      <RouterLink
        v-for="area in AREAS"
        :key="area.id"
        :to="`/area/${area.id}/${area.tabs[0]}`"
        class="chip"
        :class="{ active: route.params.areaId === area.id }"
      >
        <span class="material-symbols-outlined" aria-hidden="true">{{ area.icon }}</span>
        {{ area.label }}
      </RouterLink>
    </nav>

    <label class="search">
      <span class="material-symbols-outlined" aria-hidden="true">search</span>
      <input
        id="global-search"
        v-model="searchQuery"
        type="search"
        placeholder="Search people, papers, orgs..."
        aria-label="Search"
        autocomplete="off"
        @keyup.enter="goSearch"
        @keydown.escape="searchQuery = ''"
      />
    </label>

    <span class="badge">{{ feedStore.isRefreshing ? 'Updating…' : lastUpdated }}</span>
    <button class="btn-icon" title="Refresh feeds" aria-label="Refresh feeds" id="refresh-btn" @click="feedStore.fetchFeeds()">
      <span class="material-symbols-outlined" aria-hidden="true">refresh</span>
    </button>
    <a
      href="https://github.com/stophobia"
      target="_blank"
      rel="noopener"
      class="btn-icon"
      title="GitHub"
      aria-label="GitHub"
      id="github-header-link"
    >
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.164 6.839 9.49.5.09.682-.218.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.907-.62.069-.607.069-.607 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.252-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0 1 12 6.836a9.59 9.59 0 0 1 2.504.337c1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.202 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.137 20.16 22 16.417 22 12c0-5.523-4.477-10-10-10z"/>
      </svg>
    </a>
  </header>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { AREAS } from '@/data/areas'
import { useFeedStore } from '@/stores/feedStore'

const route = useRoute()
const router = useRouter()
const feedStore = useFeedStore()
const searchQuery = ref('')

function goSearch() {
  if (searchQuery.value.trim()) {
    router.push({ name: 'search', query: { q: searchQuery.value } })
  }
}

// When the collector last ran (feed.json's generatedAt)
const lastUpdated = computed(() => {
  if (!feedStore.lastFetchedAt) return '—'
  const diff = Date.now() - feedStore.lastFetchedAt
  if (diff < 60000) return 'Updated just now'
  if (diff < 3600000) return `Updated ${Math.floor(diff / 60000)}m ago`
  return `Updated ${Math.floor(diff / 3600000)}h ago`
})
</script>

<style scoped>
/* One bar. No breakpoints: it wraps on a narrow screen instead. */
.app-bar {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: var(--space-xs) var(--space-md);
  padding: var(--space-sm) var(--space-lg);
  background: var(--surface);
  border-bottom: 1px solid var(--border);
}

.brand {
  display: flex;
  align-items: center;
  gap: var(--space-xs);
  font-weight: var(--weight-bold);
}

.brand-mark {
  display: grid;
  place-items: center;
  width: 1.75rem;
  height: 1.75rem;
  border-radius: var(--radius-sm);
  background: var(--accent);
  color: var(--ink-inverted);
}

.area-nav {
  flex: 1;
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2xs);
}

.search {
  display: flex;
  align-items: center;
  gap: var(--space-2xs);
  flex: 1 1 12rem;
  max-width: 20rem;
  padding: var(--space-2xs) var(--space-xs);
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-sm);
  background: var(--surface);
  color: var(--ink-muted);
}

.search:focus-within { outline: 2px solid var(--accent); outline-offset: 2px; }

.search input {
  flex: 1;
  min-width: 0;
  border: none;
  outline: none;
  background: none;
  color: var(--ink);
  font-size: var(--text-sm);
}
</style>

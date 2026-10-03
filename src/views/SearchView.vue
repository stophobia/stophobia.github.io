<template>
  <div class="search-view">
    <div class="search-header">
      <h1 class="search-title">Search Results</h1>
      <p class="search-query" v-if="query">
        Showing results for <strong>"{{ query }}"</strong>
        — {{ feedStore.filtered.length }} events found
      </p>
    </div>
    <div v-if="people.length" class="search-group">
      <h2 class="search-group-title">People</h2>
      <div class="search-cards">
        <PersonCard v-for="p in people" :key="p.id" :person="p" />
      </div>
    </div>
    <div v-if="orgs.length" class="search-group">
      <h2 class="search-group-title">Organizations</h2>
      <div class="search-cards">
        <OrgCard v-for="o in orgs" :key="o.id" :org="o" />
      </div>
    </div>
    <FeedGrid />
  </div>
</template>

<script setup lang="ts">
import { computed, watch, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useFeedStore } from '@/stores/feedStore'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import PersonCard from '@/components/people/PersonCard.vue'
import OrgCard from '@/components/organizations/OrgCard.vue'
import { PEOPLE } from '@/data/people'
import { ORGANIZATIONS } from '@/data/organizations'

const route = useRoute()
const feedStore = useFeedStore()

const query = computed(() => String(route.query.q || ''))

const matches = (fields: string[]) => {
  const q = query.value.trim().toLowerCase()
  return q !== '' && fields.some((f) => f.toLowerCase().includes(q))
}
const people = computed(() => PEOPLE.filter((p) => matches([p.name, p.role, p.organization, ...p.tags])))
const orgs = computed(() => ORGANIZATIONS.filter((o) => matches([o.name, o.description, ...o.tags])))

watch(query, (val) => {
  feedStore.setFilter({ query: val })
}, { immediate: true })

// The query lives in the shared store; don't leave Area feeds filtered after leaving search
onUnmounted(() => feedStore.setFilter({ query: '' }))
</script>

<style scoped>
.search-view { padding: 24px; display: flex; flex-direction: column; gap: 20px; }
.search-header { }
.search-title { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
.search-query { font-size: 13px; color: var(--text-secondary); }
.search-query strong { color: var(--text-primary); }
.search-group { display: flex; flex-direction: column; gap: 12px; }
.search-group-title { font-size: 16px; font-weight: 700; }
.search-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }
</style>

<template>
  <div class="search-view">
    <div>
      <h1 class="page-title">Search Results</h1>
      <p class="muted" v-if="query">
        Showing results for <strong>"{{ query }}"</strong>
        — {{ feedStore.filtered.length }} events found
      </p>
    </div>
    <div v-if="people.length" class="search-group">
      <h2 class="section-title">People</h2>
      <div class="card-grid">
        <PersonCard v-for="p in people" :key="p.id" :person="p" />
      </div>
    </div>
    <div v-if="orgs.length" class="search-group">
      <h2 class="section-title">Organizations</h2>
      <div class="card-grid">
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
.search-view { display: flex; flex-direction: column; gap: var(--space-lg); }
.search-group { display: flex; flex-direction: column; gap: var(--space-sm); }
</style>

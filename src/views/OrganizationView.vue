<template>
  <div class="org-view" v-if="org">
    <!-- Hero -->
    <div class="org-hero card">
      <div class="org-hero-inner">
        <img v-if="org.logo && !logoError" :src="org.logo" :alt="org.name" class="oh-logo"
          @error="logoError = true" />
        <div v-else class="oh-logo-fallback">{{ org.name.charAt(0) }}</div>
        <div class="oh-info">
          <h1 class="page-title">{{ org.name }}</h1>
          <div class="oh-meta">
            <span class="badge">{{ typeLabel }}</span>
            <span v-for="a in org.areas" :key="a" class="badge">{{ a }}</span>
          </div>
        </div>
      </div>
      <p class="oh-desc">{{ org.description }}</p>
      <div class="oh-links">
        <a v-if="org.links.website" :href="org.links.website" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">language</span> Website</a>
        <a v-if="org.links.github" :href="org.links.github" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">code</span> GitHub</a>
        <a v-if="org.links.blog" :href="org.links.blog" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">edit_note</span> Blog</a>
        <a v-if="org.links.twitter" :href="org.links.twitter" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">alternate_email</span> Twitter</a>
      </div>
    </div>

    <!-- Tags -->
    <div class="org-section">
      <h2 class="section-title">Tags</h2>
      <div class="tag-cloud">
        <span v-for="tag in org.tags" :key="tag" class="tag">{{ tag }}</span>
      </div>
    </div>

    <!-- People (Person —works at→ Organization) -->
    <div v-if="people.length" class="org-section">
      <h2 class="section-title">People</h2>
      <div class="card-grid">
        <PersonCard v-for="person in people" :key="person.id" :person="person" />
      </div>
    </div>

    <!-- Feeds collected for this organization -->
    <div v-if="feeds.length" class="org-section">
      <h2 class="section-title">Feeds</h2>
      <div class="rss-feeds">
        <a v-for="feed in feeds" :key="feed.url" :href="feed.url" target="_blank" rel="noopener" class="rss-feed-link">
          <span class="material-symbols-outlined" aria-hidden="true">rss_feed</span> {{ feed.source }}
        </a>
      </div>
    </div>

    <!-- Events published by the organization (feeds and GitHub) -->
    <div class="org-section">
      <h2 class="section-title">Latest from {{ org.name }}</h2>
      <div class="card-grid">
        <EventCard v-for="event in ownEvents" :key="event.id" :event="event" />
        <p v-if="ownEvents.length === 0" class="muted">No events collected from {{ org.name }} yet</p>
      </div>
    </div>

    <!-- Related by topic -->
    <div v-if="relatedEvents.length" class="org-section">
      <h2 class="section-title">Related Events</h2>
      <div class="card-grid">
        <EventCard v-for="event in relatedEvents" :key="event.id" :event="event" />
      </div>
    </div>
  </div>
  <div v-else class="empty">
    <h2>Organization not found</h2>
    <RouterLink to="/" class="btn btn-primary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span> Back to Hub</RouterLink>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { ORGANIZATIONS } from '@/data/organizations'
import { PEOPLE } from '@/data/people'
import { RSS_FEEDS } from '@/data/feeds'
import { useFeedStore } from '@/stores/feedStore'
import EventCard from '@/components/feed/EventCard.vue'
import PersonCard from '@/components/people/PersonCard.vue'

const props = defineProps<{ id: string }>()
const feedStore = useFeedStore()
const logoError = ref(false)

const org = computed(() => ORGANIZATIONS.find((o) => o.id === props.id) || null)

const TYPE_LABELS: Record<string, string> = {
  ai_company: 'AI Company', hedge_fund: 'Hedge Fund', asset_manager: 'Asset Manager',
  bank: 'Bank', research: 'Research', regulator: 'Regulator', university: 'University', fintech: 'FinTech',
}

const typeLabel = computed(() => org.value ? TYPE_LABELS[org.value.type] || org.value.type : '')

const people = computed(() => (org.value ? PEOPLE.filter((p) => p.organization.includes(org.value!.name)) : []))
const feeds = computed(() => RSS_FEEDS.filter((f) => f.orgId === props.id))

const ownEvents = computed(() => {
  const gh = org.value?.links.github
  return feedStore.events
    .filter((e) => e.orgId === props.id || (gh && e.url.startsWith(`${gh}/`)))
    .slice(0, 24)
})

const relatedEvents = computed(() => {
  if (!org.value) return []
  const name = org.value.name.toLowerCase()
  const tags = org.value.tags.map((t) => t.toLowerCase())
  const own = new Set(ownEvents.value.map((e) => e.id))
  return feedStore.events
    .filter((e) =>
      !own.has(e.id) && (
        (e.organization?.toLowerCase().includes(name)) ||
        e.tags.some((t) => tags.includes(t.toLowerCase()))
      ),
    )
    .slice(0, 8)
})
</script>

<style scoped>
.org-view { display: flex; flex-direction: column; gap: var(--space-lg); }

.org-hero {
  padding: var(--space-lg);
  display: flex;
  flex-direction: column;
  gap: var(--space-md);
}

.org-hero-inner { display: flex; align-items: center; gap: var(--space-md); }

.oh-logo,
.oh-logo-fallback {
  width: 4rem;
  height: 4rem;
  border-radius: var(--radius-md);
  border: 1px solid var(--border);
  flex-shrink: 0;
}

.oh-logo { object-fit: contain; padding: var(--space-xs); }

.oh-logo-fallback {
  display: grid;
  place-items: center;
  background: var(--surface-sunken);
  color: var(--ink-muted);
  font-size: var(--text-xl);
  font-weight: var(--weight-bold);
}

.oh-info { flex: 1; display: flex; flex-direction: column; gap: var(--space-xs); }
.oh-meta,
.oh-links { display: flex; gap: var(--space-xs); flex-wrap: wrap; }
.oh-desc { color: var(--ink-muted); }

.org-section { display: flex; flex-direction: column; gap: var(--space-sm); }
.tag-cloud { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }

.rss-feeds { display: flex; flex-direction: column; gap: var(--space-2xs); }
.rss-feed-link {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2xs);
  font-size: var(--text-sm);
  color: var(--accent);
  font-family: var(--font-mono);
}
.rss-feed-link:hover { text-decoration: underline; }
</style>

<template>
  <div class="org-view" v-if="org">
    <!-- Hero -->
    <div class="org-hero glass">
      <div class="org-hero-inner">
        <img v-if="org.logo && !logoError" :src="org.logo" :alt="org.name" class="oh-logo"
          @error="logoError = true" />
        <div v-else class="oh-logo-fallback">{{ org.name.charAt(0) }}</div>
        <div class="oh-info">
          <h1 class="oh-name">{{ org.name }}</h1>
          <div class="oh-meta">
            <span class="badge" :class="typeBadgeClass">{{ typeLabel }}</span>
            <span v-for="a in org.areas" :key="a" class="badge" :class="`badge-${a}`">{{ a }}</span>
          </div>
        </div>
      </div>
      <p class="oh-desc">{{ org.description }}</p>
      <div class="oh-links">
        <a v-if="org.links.website" :href="org.links.website" target="_blank" rel="noopener" class="btn btn-ghost">🌐 Website</a>
        <a v-if="org.links.github" :href="org.links.github" target="_blank" rel="noopener" class="btn btn-ghost">🐙 GitHub</a>
        <a v-if="org.links.blog" :href="org.links.blog" target="_blank" rel="noopener" class="btn btn-ghost">✍️ Blog</a>
        <a v-if="org.links.twitter" :href="org.links.twitter" target="_blank" rel="noopener" class="btn btn-ghost">𝕏 Twitter</a>
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
      <div class="org-events-grid">
        <PersonCard v-for="person in people" :key="person.id" :person="person" />
      </div>
    </div>

    <!-- Feeds collected for this organization -->
    <div v-if="feeds.length" class="org-section">
      <h2 class="section-title">Feeds</h2>
      <div class="rss-feeds">
        <a v-for="feed in feeds" :key="feed.url" :href="feed.url" target="_blank" rel="noopener" class="rss-feed-link">
          📡 {{ feed.source }}
        </a>
      </div>
    </div>

    <!-- Events published by the organization (feeds and GitHub) -->
    <div class="org-section">
      <h2 class="section-title">Latest from {{ org.name }}</h2>
      <div class="org-events-grid">
        <EventCard v-for="event in ownEvents" :key="event.id" :event="event" />
        <div v-if="ownEvents.length === 0" class="no-events">
          <p>No events collected from {{ org.name }} yet</p>
        </div>
      </div>
    </div>

    <!-- Related by topic -->
    <div v-if="relatedEvents.length" class="org-section">
      <h2 class="section-title">Related Events</h2>
      <div class="org-events-grid">
        <EventCard v-for="event in relatedEvents" :key="event.id" :event="event" />
      </div>
    </div>
  </div>
  <div v-else class="not-found">
    <h2>Organization not found</h2>
    <RouterLink to="/" class="btn btn-primary">← Back to Hub</RouterLink>
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
const TYPE_BADGE: Record<string, string> = {
  ai_company: 'badge-ai', hedge_fund: 'badge-quant', asset_manager: 'badge-finance',
  bank: 'badge-finance', research: 'badge-research', fintech: 'badge-community', regulator: 'badge-market',
}

const typeLabel = computed(() => org.value ? TYPE_LABELS[org.value.type] || org.value.type : '')
const typeBadgeClass = computed(() => org.value ? TYPE_BADGE[org.value.type] || 'badge-ai' : '')

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
.org-view { padding: 24px; display: flex; flex-direction: column; gap: 24px; }

.org-hero {
  border-radius: var(--radius-lg);
  padding: 28px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.org-hero-inner { display: flex; align-items: center; gap: 20px; }

.oh-logo {
  width: 64px; height: 64px; border-radius: var(--radius-md);
  object-fit: contain; background: white; padding: 6px;
  border: 1px solid var(--border-subtle); flex-shrink: 0;
}

.oh-logo-fallback {
  width: 64px; height: 64px; border-radius: var(--radius-md); flex-shrink: 0;
  background: linear-gradient(135deg, #06b6d4, #10b981);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; font-weight: 700; color: white;
}

.oh-info { flex: 1; }
.oh-name { font-size: 22px; font-weight: 800; margin-bottom: 8px; }
.oh-meta { display: flex; gap: 6px; flex-wrap: wrap; }
.oh-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }
.oh-links { display: flex; gap: 8px; flex-wrap: wrap; }

.org-section { display: flex; flex-direction: column; gap: 12px; }
.section-title { font-size: 16px; font-weight: 700; }
.tag-cloud { display: flex; gap: 6px; flex-wrap: wrap; }

.rss-feeds { display: flex; flex-direction: column; gap: 6px; }
.rss-feed-link { font-size: 12px; color: var(--accent-ai); font-family: var(--font-mono); }
.rss-feed-link:hover { text-decoration: underline; }

.org-events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }
.no-events { color: var(--text-muted); font-size: 13px; padding: 24px 0; }
.not-found { padding: 60px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 16px; color: var(--text-muted); }
</style>

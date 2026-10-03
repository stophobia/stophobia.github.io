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

    <!-- RSS Feeds -->
    <div v-if="org.rssFeeds?.length" class="org-section">
      <h2 class="section-title">RSS Feeds</h2>
      <div class="rss-feeds">
        <a v-for="feed in org.rssFeeds" :key="feed" :href="feed" target="_blank" rel="noopener" class="rss-feed-link">
          📡 {{ feed }}
        </a>
      </div>
    </div>

    <!-- Related Events -->
    <div class="org-section">
      <h2 class="section-title">Recent Events</h2>
      <div class="org-events-grid">
        <EventCard v-for="event in relatedEvents" :key="event.id" :event="event" />
        <div v-if="relatedEvents.length === 0" class="no-events">
          <p>No recent events found for {{ org.name }}</p>
        </div>
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
import { useFeedStore } from '@/stores/feedStore'
import EventCard from '@/components/feed/EventCard.vue'

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
  bank: 'badge-finance', research: 'badge-research', fintech: 'badge-community',
}

const typeLabel = computed(() => org.value ? TYPE_LABELS[org.value.type] || org.value.type : '')
const typeBadgeClass = computed(() => org.value ? TYPE_BADGE[org.value.type] || 'badge-ai' : '')

const relatedEvents = computed(() => {
  if (!org.value) return []
  const name = org.value.name.toLowerCase()
  return feedStore.events
    .filter((e) =>
      (e.organization?.toLowerCase().includes(name)) ||
      (e.source?.toLowerCase().includes(name)) ||
      e.tags.some((t) => org.value!.tags.map((ot) => ot.toLowerCase()).includes(t.toLowerCase()))
    )
    .slice(0, 12)
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

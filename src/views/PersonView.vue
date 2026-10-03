<template>
  <div class="person-view" v-if="person">
    <!-- Hero -->
    <div class="person-hero glass">
      <div class="person-hero-inner">
        <img v-if="person.avatar && !avatarError" :src="person.avatar" :alt="person.name"
          class="ph-avatar" @error="avatarError = true" />
        <div v-else class="ph-avatar-fallback">{{ person.name.charAt(0) }}</div>
        <div class="ph-info">
          <h1 class="ph-name">{{ person.name }}</h1>
          <p class="ph-role">{{ person.role }}</p>
          <p class="ph-org">
            <RouterLink v-if="org" :to="`/organizations/${org.id}`" class="ph-org-link">{{ person.organization }}</RouterLink>
            <template v-else>{{ person.organization }}</template>
          </p>
          <div class="ph-areas">
            <span v-for="a in person.areas" :key="a" class="badge" :class="`badge-${a}`">{{ a }}</span>
          </div>
        </div>
      </div>
      <p class="ph-bio">{{ person.bio }}</p>
      <div class="ph-links">
        <a v-if="person.links.github" :href="person.links.github" target="_blank" rel="noopener" class="btn btn-ghost">🐙 GitHub</a>
        <a v-if="person.links.twitter" :href="person.links.twitter" target="_blank" rel="noopener" class="btn btn-ghost">𝕏 Twitter</a>
        <a v-if="person.links.scholar" :href="person.links.scholar" target="_blank" rel="noopener" class="btn btn-ghost">📚 Scholar</a>
        <a v-if="person.links.website" :href="person.links.website" target="_blank" rel="noopener" class="btn btn-ghost">🌐 Website</a>
        <a v-if="person.links.linkedin" :href="person.links.linkedin" target="_blank" rel="noopener" class="btn btn-ghost">💼 LinkedIn</a>
      </div>
    </div>

    <!-- Tags -->
    <div class="person-section">
      <h2 class="section-title">Topics</h2>
      <div class="tag-cloud">
        <span v-for="tag in person.tags" :key="tag" class="tag">{{ tag }}</span>
      </div>
    </div>

    <!-- Timeline: the person's own blog posts, papers, repos, and authored items -->
    <div class="person-section">
      <h2 class="section-title">Timeline</h2>
      <div class="person-events-grid">
        <EventCard v-for="event in timeline" :key="event.id" :event="event" />
        <div v-if="timeline.length === 0" class="no-events">
          <p>No activity collected for {{ person.name }} yet</p>
        </div>
      </div>
    </div>

    <!-- Related by organization / topic -->
    <div v-if="relatedEvents.length" class="person-section">
      <h2 class="section-title">Related Events</h2>
      <div class="person-events-grid">
        <EventCard v-for="event in relatedEvents" :key="event.id" :event="event" />
      </div>
    </div>
  </div>
  <div v-else class="not-found">
    <h2>Person not found</h2>
    <RouterLink to="/" class="btn btn-primary">← Back to Hub</RouterLink>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { PEOPLE } from '@/data/people'
import { ORGANIZATIONS } from '@/data/organizations'
import { useFeedStore } from '@/stores/feedStore'
import EventCard from '@/components/feed/EventCard.vue'

const props = defineProps<{ id: string }>()
const feedStore = useFeedStore()
const avatarError = ref(false)

const person = computed(() => PEOPLE.find((p) => p.id === props.id) || null)

// Person —works at→ Organization
const org = computed(() => (person.value ? ORGANIZATIONS.find((o) => person.value!.organization.includes(o.name)) : undefined))

const timeline = computed(() => {
  if (!person.value) return []
  const name = person.value.name.toLowerCase()
  return feedStore.events
    .filter((e) => e.personId === props.id || e.author?.toLowerCase().includes(name))
    .slice(0, 30)
})

const relatedEvents = computed(() => {
  if (!person.value) return []
  const orgName = person.value.organization.toLowerCase()
  const tags = person.value.tags.map((t) => t.toLowerCase())
  const own = new Set(timeline.value.map((e) => e.id))
  return feedStore.events
    .filter((e) =>
      !own.has(e.id) && (
        (e.organization?.toLowerCase().includes(orgName)) ||
        e.tags.some((t) => tags.includes(t.toLowerCase()))
      ),
    )
    .slice(0, 8)
})
</script>

<style scoped>
.person-view { padding: 24px; display: flex; flex-direction: column; gap: 24px; }

.person-hero {
  border-radius: var(--radius-lg);
  padding: 28px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.person-hero-inner { display: flex; align-items: flex-start; gap: 20px; }

.ph-avatar {
  width: 80px; height: 80px; border-radius: 50%; object-fit: cover;
  border: 3px solid var(--border-default); flex-shrink: 0;
}

.ph-avatar-fallback {
  width: 80px; height: 80px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  display: flex; align-items: center; justify-content: center;
  font-size: 30px; font-weight: 700; color: white;
}

.ph-info { flex: 1; }
.ph-name { font-size: 22px; font-weight: 800; margin-bottom: 4px; }
.ph-role { font-size: 14px; color: var(--text-secondary); }
.ph-org { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
.ph-org-link { color: var(--accent-ai); }
.ph-org-link:hover { text-decoration: underline; }
.ph-areas { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }
.ph-bio { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }
.ph-links { display: flex; gap: 8px; flex-wrap: wrap; }

.person-section { display: flex; flex-direction: column; gap: 12px; }
.section-title { font-size: 16px; font-weight: 700; color: var(--text-primary); }

.tag-cloud { display: flex; gap: 6px; flex-wrap: wrap; }

.person-events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }

.no-events { color: var(--text-muted); font-size: 13px; padding: 24px 0; }

.not-found { padding: 60px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 16px; color: var(--text-muted); }
</style>

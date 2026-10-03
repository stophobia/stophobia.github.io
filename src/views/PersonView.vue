<template>
  <div class="person-view" v-if="person">
    <!-- Hero -->
    <div class="person-hero card">
      <div class="person-hero-inner">
        <img v-if="person.avatar && !avatarError" :src="person.avatar" :alt="person.name"
          class="ph-avatar" @error="avatarError = true" />
        <div v-else class="ph-avatar-fallback">{{ person.name.charAt(0) }}</div>
        <div class="ph-info">
          <h1 class="page-title">{{ person.name }}</h1>
          <p class="ph-role">{{ person.role }}</p>
          <p class="ph-org">
            <RouterLink v-if="org" :to="`/organizations/${org.id}`" class="ph-org-link">{{ person.organization }}</RouterLink>
            <template v-else>{{ person.organization }}</template>
          </p>
          <div class="ph-areas">
            <span v-for="a in person.areas" :key="a" class="badge">{{ a }}</span>
          </div>
        </div>
      </div>
      <p class="ph-bio">{{ person.bio }}</p>
      <div class="ph-links">
        <a v-if="person.links.github" :href="person.links.github" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">code</span> GitHub</a>
        <a v-if="person.links.twitter" :href="person.links.twitter" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">alternate_email</span> Twitter</a>
        <a v-if="person.links.scholar" :href="person.links.scholar" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">school</span> Scholar</a>
        <a v-if="person.links.website" :href="person.links.website" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">language</span> Website</a>
        <a v-if="person.links.linkedin" :href="person.links.linkedin" target="_blank" rel="noopener" class="btn btn-ghost"><span class="material-symbols-outlined" aria-hidden="true">work</span> LinkedIn</a>
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
      <div class="card-grid">
        <EventCard v-for="event in timeline" :key="event.id" :event="event" />
        <p v-if="timeline.length === 0" class="muted">No activity collected for {{ person.name }} yet</p>
      </div>
    </div>

    <!-- Related by organization / topic -->
    <div v-if="relatedEvents.length" class="person-section">
      <h2 class="section-title">Related Events</h2>
      <div class="card-grid">
        <EventCard v-for="event in relatedEvents" :key="event.id" :event="event" />
      </div>
    </div>
  </div>
  <div v-else class="empty">
    <h2>Person not found</h2>
    <RouterLink to="/" class="btn btn-primary"><span class="material-symbols-outlined" aria-hidden="true">arrow_back</span> Back to Hub</RouterLink>
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
.person-view { display: flex; flex-direction: column; gap: var(--space-lg); }

.person-hero {
  padding: var(--space-lg);
  display: flex;
  flex-direction: column;
  gap: var(--space-md);
}

.person-hero-inner { display: flex; align-items: flex-start; gap: var(--space-md); }

.ph-avatar,
.ph-avatar-fallback {
  width: 5rem;
  height: 5rem;
  border-radius: var(--radius-full);
  border: 1px solid var(--border);
  flex-shrink: 0;
}

.ph-avatar { object-fit: cover; }

.ph-avatar-fallback {
  display: grid;
  place-items: center;
  background: var(--surface-sunken);
  color: var(--ink-muted);
  font-size: var(--text-xl);
  font-weight: var(--weight-bold);
}

.ph-info { flex: 1; display: flex; flex-direction: column; gap: var(--space-3xs); }
.ph-role { color: var(--ink-muted); }
.ph-org { font-size: var(--text-sm); color: var(--ink-muted); }
.ph-org-link { color: var(--accent); }
.ph-org-link:hover { text-decoration: underline; }
.ph-areas { display: flex; gap: var(--space-xs); flex-wrap: wrap; margin-top: var(--space-xs); }
.ph-bio { color: var(--ink-muted); }
.ph-links { display: flex; gap: var(--space-xs); flex-wrap: wrap; }

.person-section { display: flex; flex-direction: column; gap: var(--space-sm); }
.tag-cloud { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

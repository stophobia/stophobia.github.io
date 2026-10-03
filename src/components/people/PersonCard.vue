<template>
  <RouterLink :to="`/people/${person.id}`" class="person-card card">
    <div class="person-header">
      <div class="person-avatar-wrap">
        <img
          v-if="person.avatar"
          :src="person.avatar"
          :alt="person.name"
          class="person-avatar"
          @error="showFallback = true"
        />
        <div v-if="!person.avatar || showFallback" class="person-avatar-fallback">
          {{ person.name.charAt(0) }}
        </div>
      </div>
      <div class="person-info">
        <h3 class="person-name">{{ person.name }}</h3>
        <p class="person-role">{{ person.role }}</p>
        <p class="person-org">{{ person.organization }}</p>
      </div>
    </div>

    <p class="person-bio">{{ person.bio }}</p>

    <div class="person-footer">
      <div class="person-areas">
        <span
          v-for="area in person.areas"
          :key="area"
          class="badge"
        >{{ area }}</span>
      </div>
      <div class="person-links">
        <a
          v-if="person.links.github"
          :href="person.links.github"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          @click.stop
          title="GitHub"
          aria-label="GitHub"
        ><span class="material-symbols-outlined" aria-hidden="true">code</span></a>
        <a
          v-if="person.links.twitter"
          :href="person.links.twitter"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          @click.stop
          title="Twitter/X"
          aria-label="Twitter/X"
        ><span class="material-symbols-outlined" aria-hidden="true">alternate_email</span></a>
        <a
          v-if="person.links.scholar"
          :href="person.links.scholar"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          @click.stop
          title="Google Scholar"
          aria-label="Google Scholar"
        ><span class="material-symbols-outlined" aria-hidden="true">school</span></a>
        <a
          v-if="person.links.website"
          :href="person.links.website"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          @click.stop
          title="Website"
          aria-label="Website"
        ><span class="material-symbols-outlined" aria-hidden="true">language</span></a>
      </div>
    </div>
  </RouterLink>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { Person } from '@/types'
defineProps<{ person: Person }>()
const showFallback = ref(false)
</script>

<style scoped>
.person-card {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
  padding: var(--space-md);
}

.person-header { display: flex; gap: var(--space-sm); align-items: flex-start; }

.person-avatar,
.person-avatar-fallback {
  width: 3.25rem;
  height: 3.25rem;
  border-radius: var(--radius-full);
  border: 1px solid var(--border);
}

.person-avatar { object-fit: cover; }

.person-avatar-fallback {
  display: grid;
  place-items: center;
  background: var(--surface-sunken);
  color: var(--ink-muted);
  font-size: var(--text-lg);
  font-weight: var(--weight-bold);
}

.person-info { flex: 1; min-width: 0; }
.person-name { font-size: var(--text-md); }
.person-role { font-size: var(--text-sm); }
.person-org { font-size: var(--text-xs); color: var(--ink-muted); }

.person-bio {
  font-size: var(--text-sm);
  color: var(--ink-muted);
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.person-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
}

.person-areas,
.person-links { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

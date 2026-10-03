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
          :class="`badge-${area}`"
        >{{ area }}</span>
      </div>
      <div class="person-links">
        <a
          v-if="person.links.github"
          :href="person.links.github"
          target="_blank"
          rel="noopener"
          class="person-link"
          @click.stop
          title="GitHub"
        >🐙</a>
        <a
          v-if="person.links.twitter"
          :href="person.links.twitter"
          target="_blank"
          rel="noopener"
          class="person-link"
          @click.stop
          title="Twitter/X"
        >𝕏</a>
        <a
          v-if="person.links.scholar"
          :href="person.links.scholar"
          target="_blank"
          rel="noopener"
          class="person-link"
          @click.stop
          title="Google Scholar"
        >📚</a>
        <a
          v-if="person.links.website"
          :href="person.links.website"
          target="_blank"
          rel="noopener"
          class="person-link"
          @click.stop
          title="Website"
        >🌐</a>
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
  gap: 12px;
  padding: 18px;
  cursor: pointer;
}

.person-header { display: flex; gap: 12px; align-items: flex-start; }

.person-avatar-wrap { flex-shrink: 0; }

.person-avatar {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--border-default);
}

.person-avatar-fallback {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  font-weight: 700;
  color: white;
}

.person-info { flex: 1; min-width: 0; }

.person-name {
  font-size: 15px;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.2;
  margin-bottom: 2px;
}

.person-role {
  font-size: 12px;
  color: var(--text-secondary);
  line-height: 1.3;
}

.person-org {
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 2px;
}

.person-bio {
  font-size: 12px;
  color: var(--text-secondary);
  line-height: 1.5;
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

.person-areas { display: flex; gap: 4px; flex-wrap: wrap; }

.person-links { display: flex; gap: 8px; }

.person-link {
  font-size: 14px;
  opacity: 0.6;
  transition: opacity var(--transition-fast);
}
.person-link:hover { opacity: 1; }
</style>

<template>
  <RouterLink :to="`/organizations/${org.id}`" class="org-card card">
    <div class="org-header">
      <div class="org-logo-wrap">
        <img
          v-if="org.logo"
          v-show="!showFallback"
          :src="org.logo"
          :alt="org.name"
          class="org-logo"
          @error="showFallback = true"
        />
        <div v-if="!org.logo || showFallback" class="org-logo-fallback">
          {{ org.name.charAt(0) }}
        </div>
      </div>
      <div class="org-info">
        <h3 class="org-name">{{ org.name }}</h3>
        <span class="badge org-type-badge">{{ typeLabel }}</span>
      </div>
    </div>

    <p class="org-desc">{{ org.description }}</p>

    <div class="org-footer">
      <div class="org-areas">
        <span
          v-for="area in org.areas"
          :key="area"
          class="badge"
        >{{ area }}</span>
      </div>
      <div class="org-links">
        <a
          v-if="org.links.github"
          :href="org.links.github"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          title="GitHub"
          aria-label="GitHub"
          @click.stop
        ><span class="material-symbols-outlined" aria-hidden="true">code</span></a>
        <a
          v-if="org.links.website"
          :href="org.links.website"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          title="Website"
          aria-label="Website"
          @click.stop
        ><span class="material-symbols-outlined" aria-hidden="true">language</span></a>
        <a
          v-if="org.links.blog"
          :href="org.links.blog"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          title="Blog"
          aria-label="Blog"
          @click.stop
        ><span class="material-symbols-outlined" aria-hidden="true">edit_note</span></a>
      </div>
    </div>
  </RouterLink>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Organization } from '@/types'

const props = defineProps<{ org: Organization }>()
const showFallback = ref(false)

const TYPE_LABELS: Record<string, string> = {
  ai_company: 'AI Company',
  hedge_fund: 'Hedge Fund',
  asset_manager: 'Asset Manager',
  bank: 'Bank',
  research: 'Research',
  regulator: 'Regulator',
  university: 'University',
  fintech: 'FinTech',
}

const typeLabel = computed(() => TYPE_LABELS[props.org.type] || props.org.type)
</script>

<style scoped>
.org-card {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
  padding: var(--space-md);
}

.org-header { display: flex; gap: var(--space-sm); align-items: center; }

.org-logo,
.org-logo-fallback {
  width: 2.75rem;
  height: 2.75rem;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
}

.org-logo { object-fit: contain; padding: var(--space-2xs); }

.org-logo-fallback {
  display: grid;
  place-items: center;
  background: var(--surface-sunken);
  color: var(--ink-muted);
  font-size: var(--text-lg);
  font-weight: var(--weight-bold);
}

.org-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: var(--space-2xs); }
.org-name { font-size: var(--text-md); }
.org-type-badge { align-self: flex-start; }

.org-desc {
  font-size: var(--text-sm);
  color: var(--ink-muted);
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.org-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
}

.org-areas,
.org-links { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

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
        <span class="badge org-type-badge" :class="typeBadgeClass">{{ typeLabel }}</span>
      </div>
    </div>

    <p class="org-desc">{{ org.description }}</p>

    <div class="org-footer">
      <div class="org-areas">
        <span
          v-for="area in org.areas"
          :key="area"
          class="badge"
          :class="`badge-${area}`"
        >{{ area }}</span>
      </div>
      <div class="org-links">
        <a
          v-if="org.links.github"
          :href="org.links.github"
          target="_blank"
          rel="noopener"
          class="org-link"
          @click.stop
        >🐙</a>
        <a
          v-if="org.links.website"
          :href="org.links.website"
          target="_blank"
          rel="noopener"
          class="org-link"
          @click.stop
        >🌐</a>
        <a
          v-if="org.links.blog"
          :href="org.links.blog"
          target="_blank"
          rel="noopener"
          class="org-link"
          @click.stop
        >✍️</a>
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

const TYPE_BADGE_CLASS: Record<string, string> = {
  ai_company: 'badge-ai',
  hedge_fund: 'badge-quant',
  asset_manager: 'badge-finance',
  bank: 'badge-finance',
  research: 'badge-research',
  regulator: 'badge-market',
  fintech: 'badge-community',
}

const typeLabel = computed(() => TYPE_LABELS[props.org.type] || props.org.type)
const typeBadgeClass = computed(() => TYPE_BADGE_CLASS[props.org.type] || 'badge-ai')
</script>

<style scoped>
.org-card {
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding: 18px;
  cursor: pointer;
}

.org-header { display: flex; gap: 12px; align-items: center; }

.org-logo-wrap { flex-shrink: 0; }

.org-logo {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  object-fit: contain;
  background: white;
  padding: 4px;
  border: 1px solid var(--border-subtle);
}

.org-logo-fallback {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: linear-gradient(135deg, #06b6d4, #10b981);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: 700;
  color: white;
}

.org-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 4px; }

.org-name {
  font-size: 14px;
  font-weight: 700;
  color: var(--text-primary);
}

.org-type-badge { font-size: 10px; align-self: flex-start; }

.org-desc {
  font-size: 12px;
  color: var(--text-secondary);
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.org-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.org-areas { display: flex; gap: 4px; flex-wrap: wrap; }
.org-links { display: flex; gap: 8px; }
.org-link { font-size: 14px; opacity: 0.6; transition: opacity var(--transition-fast); }
.org-link:hover { opacity: 1; }
</style>

<template>
  <div class="category-tab">
    <h2 class="section-title">Podcasts</h2>
    <div class="card-grid">
      <a v-for="p in PODCASTS" :key="p.name" :href="p.url" target="_blank" rel="noopener" class="podcast-card card">
        <div class="pc-name">{{ p.name }}</div>
        <div class="muted">{{ p.host }}</div>
        <div class="pc-desc">{{ p.desc }}</div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const PODCASTS = [
  { name: 'Lex Fridman Podcast', host: 'Lex Fridman', url: 'https://lexfridman.com/podcast', desc: 'Conversations with AI researchers & founders' },
  { name: 'Dwarkesh Podcast', host: 'Dwarkesh Patel', url: 'https://www.dwarkeshpatel.com', desc: 'AI, science, and economic history' },
  { name: 'Latent Space', host: 'swyx & Alessio', url: 'https://www.latent.space', desc: 'AI engineering & research podcast' },
  { name: 'The TWIML AI Podcast', host: 'Sam Charrington', url: 'https://twimlai.com/podcast', desc: 'ML research interviews' },
  { name: 'Acquired', host: 'Ben & David', url: 'https://www.acquired.fm', desc: 'Tech company deep dives' },
  { name: 'Odd Lots', host: 'Bloomberg', url: 'https://www.bloomberg.com/odd-lots', desc: 'Finance & macro economics' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.podcast-card { padding: var(--space-sm) var(--space-md); }
.pc-name { font-weight: var(--weight-bold); }
.pc-desc { font-size: var(--text-sm); margin-top: var(--space-2xs); }
</style>

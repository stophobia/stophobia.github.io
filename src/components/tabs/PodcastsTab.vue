<template>
  <div class="category-tab">
    <h2 class="tab-section-title">🎙️ Podcasts</h2>
    <div class="podcast-list">
      <a v-for="p in PODCASTS" :key="p.name" :href="p.url" target="_blank" rel="noopener" class="podcast-card card">
        <div class="pc-icon">{{ p.icon }}</div>
        <div class="pc-info">
          <div class="pc-name">{{ p.name }}</div>
          <div class="pc-host">{{ p.host }}</div>
          <div class="pc-desc">{{ p.desc }}</div>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const PODCASTS = [
  { name: 'Lex Fridman Podcast', host: 'Lex Fridman', url: 'https://lexfridman.com/podcast', icon: '🎧', desc: 'Conversations with AI researchers & founders' },
  { name: 'Dwarkesh Podcast', host: 'Dwarkesh Patel', url: 'https://www.dwarkeshpatel.com', icon: '🎤', desc: 'AI, science, and economic history' },
  { name: 'Latent Space', host: 'swyx & Alessio', url: 'https://www.latent.space', icon: '🌌', desc: 'AI engineering & research podcast' },
  { name: 'The TWIML AI Podcast', host: 'Sam Charrington', url: 'https://twimlai.com/podcast', icon: '🤖', desc: 'ML research interviews' },
  { name: 'Acquired', host: 'Ben & David', url: 'https://www.acquired.fm', icon: '💼', desc: 'Tech company deep dives' },
  { name: 'Odd Lots', host: 'Bloomberg', url: 'https://www.bloomberg.com/odd-lots', icon: '📈', desc: 'Finance & macro economics' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 16px; }
.tab-section-title { font-size: 18px; font-weight: 700; }
.podcast-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }
.podcast-card { display: flex; align-items: flex-start; gap: 14px; padding: 16px; }
.pc-icon { font-size: 28px; flex-shrink: 0; margin-top: 2px; }
.pc-name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
.pc-host { font-size: 12px; color: var(--accent-ai); margin-top: 2px; }
.pc-desc { font-size: 12px; color: var(--text-secondary); margin-top: 4px; line-height: 1.4; }
</style>

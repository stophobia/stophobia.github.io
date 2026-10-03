<template>
  <div class="category-tab">
    <h2 class="tab-section-title">🎬 Videos & Lectures</h2>
    <div class="video-channels">
      <a v-for="ch in CHANNELS" :key="ch.name" :href="ch.url" target="_blank" rel="noopener" class="video-channel-card card">
        <div class="vc-icon">{{ ch.icon }}</div>
        <div>
          <div class="vc-name">{{ ch.name }}</div>
          <div class="vc-desc">{{ ch.desc }}</div>
        </div>
        <span class="vc-arrow">→</span>
      </a>
    </div>
    <FeedGrid :area-id="areaId" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const CHANNELS = [
  { name: 'Two Minute Papers', url: 'https://www.youtube.com/@TwoMinutePapers', icon: '📄', desc: 'AI paper summaries' },
  { name: 'Yannic Kilcher', url: 'https://www.youtube.com/@YannicKilcher', icon: '🔬', desc: 'Deep ML paper readings' },
  { name: 'DeepLearning.AI', url: 'https://www.youtube.com/@Deeplearningai', icon: '🤖', desc: 'Andrew Ng courses & talks' },
  { name: 'Andrej Karpathy', url: 'https://www.youtube.com/@AndrejKarpathy', icon: '🧠', desc: 'LLM from scratch lectures' },
  { name: 'NVIDIA GTC', url: 'https://www.youtube.com/@NVIDIAGTC', icon: '💚', desc: 'GPU AI research talks' },
  { name: 'OpenAI', url: 'https://www.youtube.com/@OpenAI', icon: '🌐', desc: 'Model releases & demos' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 16px; }
.tab-section-title { font-size: 18px; font-weight: 700; }
.video-channels { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 10px; }
.video-channel-card { display: flex; align-items: center; gap: 12px; padding: 14px; }
.vc-icon { font-size: 24px; flex-shrink: 0; }
.vc-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
.vc-desc { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.vc-arrow { margin-left: auto; color: var(--text-muted); font-size: 14px; flex-shrink: 0; }
</style>

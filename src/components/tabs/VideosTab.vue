<template>
  <div class="category-tab">
    <h2 class="section-title">Videos & Lectures</h2>
    <div class="card-grid">
      <a v-for="ch in CHANNELS" :key="ch.name" :href="ch.url" target="_blank" rel="noopener" class="video-channel-card card">
        <div>
          <div class="vc-name">{{ ch.name }}</div>
          <div class="muted">{{ ch.desc }}</div>
        </div>
        <span class="material-symbols-outlined vc-arrow" aria-hidden="true">open_in_new</span>
      </a>
    </div>
    <FeedGrid :area-id="areaId" :override-categories="['video']" hide-filter />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const CHANNELS = [
  { name: 'Two Minute Papers', url: 'https://www.youtube.com/@TwoMinutePapers', desc: 'AI paper summaries' },
  { name: 'Yannic Kilcher', url: 'https://www.youtube.com/@YannicKilcher', desc: 'Deep ML paper readings' },
  { name: 'DeepLearning.AI', url: 'https://www.youtube.com/@Deeplearningai', desc: 'Andrew Ng courses & talks' },
  { name: 'Andrej Karpathy', url: 'https://www.youtube.com/@AndrejKarpathy', desc: 'LLM from scratch lectures' },
  { name: 'NVIDIA GTC', url: 'https://www.youtube.com/@NVIDIAGTC', desc: 'GPU AI research talks' },
  { name: 'OpenAI', url: 'https://www.youtube.com/@OpenAI', desc: 'Model releases & demos' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.video-channel-card { display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm) var(--space-md); }
.vc-name { font-weight: var(--weight-bold); }
.vc-arrow { margin-left: auto; color: var(--ink-muted); }
</style>

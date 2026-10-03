<template>
  <div class="category-tab">
    <div>
      <h2 class="section-title">Latest Blog Posts</h2>
      <p class="muted">From AI companies, researchers, and quant practitioners.</p>
    </div>
    <div class="blog-sources-list">
      <a v-for="b in BLOG_SOURCES" :key="b.name" :href="b.url" target="_blank" rel="noopener" class="blog-source-card card">
        <div class="blog-source-name">{{ b.name }}</div>
        <div class="muted">{{ b.desc }}</div>
      </a>
    </div>
    <FeedGrid :area-id="areaId" :override-categories="['blog_post']" hide-filter />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const BLOG_SOURCES = [
  { name: 'Lil\'Log', url: 'https://lilianweng.github.io', desc: 'Lilian Weng — LLM, Agents, Alignment' },
  { name: 'Sebastian Raschka', url: 'https://sebastianraschka.com/blog', desc: 'LLM internals, PyTorch, research' },
  { name: 'Chip Huyen', url: 'https://huyenchip.com/blog', desc: 'MLOps, LLM, AI engineering' },
  { name: 'Nathan Lambert', url: 'https://www.interconnects.ai', desc: 'RLHF, alignment, open-source LLMs' },
  { name: 'Karpathy Blog', url: 'https://karpathy.ai', desc: 'LLM education, research commentary' },
  { name: 'Quantocracy', url: 'https://quantocracy.com', desc: 'Quant trading blog aggregator' },
  { name: 'AQR Insights', url: 'https://www.aqr.com/Insights', desc: 'Factor investing, asset management' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.blog-sources-list { display: flex; flex-wrap: wrap; gap: var(--space-xs); }
.blog-source-card { padding: var(--space-xs) var(--space-sm); }
.blog-source-name { font-weight: var(--weight-medium); }
</style>

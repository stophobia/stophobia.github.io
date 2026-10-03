<template>
  <div class="category-tab">
    <div class="blog-sources-header">
      <h2>✍️ Latest Blog Posts</h2>
      <p class="sub-desc">From AI companies, researchers, and quant practitioners.</p>
    </div>
    <div class="blog-sources-list">
      <a v-for="b in BLOG_SOURCES" :key="b.name" :href="b.url" target="_blank" rel="noopener" class="blog-source-card card">
        <span class="blog-source-icon">{{ b.icon }}</span>
        <div>
          <div class="blog-source-name">{{ b.name }}</div>
          <div class="blog-source-desc">{{ b.desc }}</div>
        </div>
      </a>
    </div>
    <FeedGrid :area-id="areaId" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const BLOG_SOURCES = [
  { name: 'Lil\'Log', url: 'https://lilianweng.github.io', icon: '📓', desc: 'Lilian Weng — LLM, Agents, Alignment' },
  { name: 'Sebastian Raschka', url: 'https://sebastianraschka.com/blog', icon: '📘', desc: 'LLM internals, PyTorch, research' },
  { name: 'Chip Huyen', url: 'https://huyenchip.com/blog', icon: '🤖', desc: 'MLOps, LLM, AI engineering' },
  { name: 'Nathan Lambert', url: 'https://www.interconnects.ai', icon: '🔗', desc: 'RLHF, alignment, open-source LLMs' },
  { name: 'Karpathy Blog', url: 'https://karpathy.ai', icon: '🧠', desc: 'LLM education, research commentary' },
  { name: 'Quantocracy', url: 'https://quantocracy.com', icon: '📐', desc: 'Quant trading blog aggregator' },
  { name: 'AQR Insights', url: 'https://www.aqr.com/Insights', icon: '📈', desc: 'Factor investing, asset management' },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 16px; }
.blog-sources-header h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
.sub-desc { font-size: 13px; color: var(--text-muted); }
.blog-sources-list { display: flex; flex-wrap: wrap; gap: 10px; }
.blog-source-card { display: flex; align-items: center; gap: 10px; padding: 12px 16px; flex: 0 0 auto; }
.blog-source-icon { font-size: 20px; }
.blog-source-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
.blog-source-desc { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
</style>

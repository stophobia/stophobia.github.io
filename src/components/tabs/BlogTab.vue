<template>
  <!-- A wrapper, so AreaView's override-categories can't fall through onto FeedGrid -->
  <div class="category-tab">
    <FeedGrid :area-id="areaId" :override-categories="['blog_post']" :channels="BLOG_SOURCES" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId, Channel } from '@/types'
defineProps<{ areaId: AreaId }>()

const BLOG_SOURCES: Channel[] = [
  { name: 'Lil\'Log', url: 'https://lilianweng.github.io', desc: 'Lilian Weng — LLM, Agents, Alignment', area: 'ai' },
  { name: 'Sebastian Raschka', url: 'https://sebastianraschka.com/blog', desc: 'LLM internals, PyTorch, research', area: 'ai' },
  { name: 'Chip Huyen', url: 'https://huyenchip.com/blog', desc: 'MLOps, LLM, AI engineering', area: 'ai' },
  { name: 'Nathan Lambert', url: 'https://www.interconnects.ai', desc: 'RLHF, alignment, open-source LLMs', area: 'ai' },
  { name: 'Karpathy Blog', url: 'https://karpathy.ai', desc: 'LLM education, research commentary', area: 'ai' },
  { name: 'Quantocracy', url: 'https://quantocracy.com', desc: 'Quant trading blog aggregator', area: 'quant' },
  { name: 'AQR Insights', url: 'https://www.aqr.com/Insights', desc: 'Factor investing, asset management', area: 'finance' },
]
</script>

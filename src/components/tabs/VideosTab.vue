<template>
  <!-- A wrapper, so AreaView's override-categories can't fall through onto FeedGrid -->
  <div class="category-tab">
    <FeedGrid :area-id="areaId" :override-categories="['video']" :channels="CHANNELS" />
  </div>
</template>

<script setup lang="ts">
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId, Channel } from '@/types'
defineProps<{ areaId: AreaId }>()

const CHANNELS: Channel[] = [
  { name: 'Two Minute Papers', url: 'https://www.youtube.com/@TwoMinutePapers', desc: 'AI paper summaries', area: 'research' },
  { name: 'Yannic Kilcher', url: 'https://www.youtube.com/@YannicKilcher', desc: 'Deep ML paper readings', area: 'research' },
  { name: 'DeepLearning.AI', url: 'https://www.youtube.com/@Deeplearningai', desc: 'Andrew Ng courses & talks', area: 'ai' },
  { name: 'Andrej Karpathy', url: 'https://www.youtube.com/@AndrejKarpathy', desc: 'LLM from scratch lectures', area: 'ai' },
  { name: 'NVIDIA GTC', url: 'https://www.youtube.com/@NVIDIAGTC', desc: 'GPU AI research talks', area: 'ai' },
  { name: 'OpenAI', url: 'https://www.youtube.com/@OpenAI', desc: 'Model releases & demos', area: 'ai' },
]
</script>

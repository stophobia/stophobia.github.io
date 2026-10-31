<template>
  <div class="category-tab">
    <FilterBar v-model="query" :count="shown.length" placeholder="Search podcasts…" />
    <ChannelGrid :channels="shown" />
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import FilterBar from '@/components/layout/FilterBar.vue'
import ChannelGrid from '@/components/feed/ChannelGrid.vue'
import { matches } from '@/stores/feedStore'
import type { AreaId, Channel } from '@/types'
defineProps<{ areaId: AreaId }>()

const PODCASTS: Channel[] = [
  { name: 'Lex Fridman Podcast', url: 'https://lexfridman.com/podcast', desc: 'Lex Fridman — Conversations with AI researchers & founders', area: 'ai' },
  { name: 'Dwarkesh Podcast', url: 'https://www.dwarkeshpatel.com', desc: 'Dwarkesh Patel — AI, science, and economic history', area: 'ai' },
  { name: 'Latent Space', url: 'https://www.latent.space', desc: 'swyx & Alessio — AI engineering & research podcast', area: 'ai' },
  { name: 'The TWIML AI Podcast', url: 'https://twimlai.com/podcast', desc: 'Sam Charrington — ML research interviews', area: 'ai' },
  { name: 'Acquired', url: 'https://www.acquired.fm', desc: 'Ben & David — Tech company deep dives', area: 'finance' },
  { name: 'Odd Lots', url: 'https://www.bloomberg.com/odd-lots', desc: 'Bloomberg — Finance & macro economics', area: 'market' },
]

const query = ref('')
const shown = computed(() => PODCASTS.filter((p) => matches(query.value, [p.name, p.desc, p.area])))
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
</style>

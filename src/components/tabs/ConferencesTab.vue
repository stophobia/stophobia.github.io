<template>
  <div class="category-tab">
    <FilterBar v-model="query" :count="shown.length" placeholder="Search conferences…" />
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

// In date order; update as editions are announced (dates checked 2026-10-03)
const CONFERENCES: Channel[] = [
  { name: 'QuantMinds 2026', url: 'https://informaconnect.com/quantminds-international/', desc: 'QuantMinds International — Nov 16–19, 2026 · London, UK', area: 'quant' },
  { name: 'NeurIPS 2026', url: 'https://neurips.cc', desc: 'Neural Information Processing Systems — Dec 6–12, 2026 · Sydney, Australia', area: 'ai' },
  { name: 'AAAI-27', url: 'https://aaai.org', desc: 'AAAI Conference on Artificial Intelligence — Feb 16–23, 2027 · Montréal, Canada', area: 'ai' },
  { name: 'ICLR 2027', url: 'https://iclr.cc', desc: 'International Conference on Learning Representations — Apr 26–30, 2027 · San Francisco, US', area: 'ai' },
  { name: 'ICML 2027', url: 'https://icml.cc', desc: 'International Conference on Machine Learning — dates TBA', area: 'ai' },
  { name: 'ACL 2027', url: 'https://2027.aclweb.org', desc: 'Association for Computational Linguistics — Aug 17–22, 2027 · Kyoto, Japan', area: 'research' },
]

const query = ref('')
const shown = computed(() => CONFERENCES.filter((c) => matches(query.value, [c.name, c.desc, c.area])))
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
</style>

<template>
  <div class="category-tab">
    <h2 class="tab-section-title">🎤 Conferences & Events</h2>
    <div class="conf-year-groups">
      <div v-for="group in groupedConfs" :key="group.year">
        <h3 class="conf-year">{{ group.year }}</h3>
        <div class="conf-grid">
          <div v-for="conf in group.confs" :key="conf.name" class="conf-card card">
            <div class="conf-header">
              <div>
                <div class="conf-name">{{ conf.name }}</div>
                <div class="conf-fullname">{{ conf.fullName }}</div>
              </div>
              <span class="badge" :class="`badge-${conf.area}`">{{ conf.area }}</span>
            </div>
            <div class="conf-detail">
              <span class="conf-date">📅 {{ conf.date }}</span>
              <span v-if="conf.location" class="conf-loc">📍 {{ conf.location }}</span>
            </div>
            <div class="conf-topics">
              <span v-for="t in conf.topics" :key="t" class="tag">{{ t }}</span>
            </div>
            <a v-if="conf.url" :href="conf.url" target="_blank" rel="noopener" class="conf-link">Visit Website →</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

// Update as editions are announced (dates checked 2026-10-03)
const CONFERENCES = [
  { name: 'QuantMinds 2026', fullName: 'QuantMinds International', year: 2026, date: 'Nov 16–19, 2026', location: 'London, UK', area: 'quant', url: 'https://informaconnect.com/quantminds-international/', topics: ['quant-finance', 'derivatives', 'risk'] },
  { name: 'NeurIPS 2026', fullName: 'Neural Information Processing Systems', year: 2026, date: 'Dec 6–12, 2026', location: 'Sydney, Australia', area: 'ai', url: 'https://neurips.cc', topics: ['deep-learning', 'LLM', 'RL'] },
  { name: 'AAAI-27', fullName: 'AAAI Conference on Artificial Intelligence', year: 2027, date: 'Feb 16–23, 2027', location: 'Montréal, Canada', area: 'ai', url: 'https://aaai.org', topics: ['AI', 'reasoning', 'multi-agent'] },
  { name: 'ICLR 2027', fullName: 'International Conference on Learning Representations', year: 2027, date: 'Apr 26–30, 2027', location: 'San Francisco, US', area: 'ai', url: 'https://iclr.cc', topics: ['representation-learning', 'deep-learning'] },
  { name: 'ICML 2027', fullName: 'International Conference on Machine Learning', year: 2027, date: 'TBA', location: '', area: 'ai', url: 'https://icml.cc', topics: ['ML', 'optimization', 'theory'] },
  { name: 'ACL 2027', fullName: 'Association for Computational Linguistics', year: 2027, date: 'Aug 17–22, 2027', location: 'Kyoto, Japan', area: 'research', url: 'https://2027.aclweb.org', topics: ['NLP', 'LLM', 'linguistics'] },
]

const groupedConfs = computed(() => {
  const map: Record<number, typeof CONFERENCES> = {}
  for (const c of CONFERENCES) {
    if (!map[c.year]) map[c.year] = []
    map[c.year].push(c)
  }
  return Object.entries(map)
    .sort(([a], [b]) => Number(a) - Number(b))
    .map(([year, confs]) => ({ year: Number(year), confs }))
})
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 20px; }
.tab-section-title { font-size: 18px; font-weight: 700; }
.conf-year { font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 10px; }
.conf-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }
.conf-card { display: flex; flex-direction: column; gap: 10px; padding: 16px; }
.conf-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
.conf-name { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.conf-fullname { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
.conf-detail { display: flex; gap: 12px; font-size: 12px; color: var(--text-secondary); flex-wrap: wrap; }
.conf-topics { display: flex; gap: 4px; flex-wrap: wrap; }
.conf-link { font-size: 12px; color: var(--accent-ai); font-weight: 500; margin-top: auto; }
.conf-link:hover { text-decoration: underline; }
</style>

<template>
  <div class="category-tab">
    <h2 class="section-title">Conferences & Events</h2>
    <div class="conf-year-groups">
      <div v-for="group in groupedConfs" :key="group.year">
        <h3 class="conf-year">{{ group.year }}</h3>
        <div class="card-grid">
          <div v-for="conf in group.confs" :key="conf.name" class="conf-card card">
            <div class="conf-header">
              <div>
                <div class="conf-name">{{ conf.name }}</div>
                <div class="muted">{{ conf.fullName }}</div>
              </div>
              <span class="badge">{{ conf.area }}</span>
            </div>
            <div class="conf-detail">
              <span><span class="material-symbols-outlined" aria-hidden="true">calendar_today</span> {{ conf.date }}</span>
              <span v-if="conf.location"><span class="material-symbols-outlined" aria-hidden="true">location_on</span> {{ conf.location }}</span>
            </div>
            <div class="conf-topics">
              <span v-for="t in conf.topics" :key="t" class="tag">{{ t }}</span>
            </div>
            <a v-if="conf.url" :href="conf.url" target="_blank" rel="noopener" class="conf-link">Website <span class="material-symbols-outlined" aria-hidden="true">open_in_new</span></a>
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
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.conf-year-groups { display: flex; flex-direction: column; gap: var(--space-lg); }
.conf-year { font-size: var(--text-md); margin-bottom: var(--space-xs); }
.conf-card { display: flex; flex-direction: column; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); }
.conf-header { display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-xs); }
.conf-name { font-weight: var(--weight-bold); }
.conf-detail { display: flex; gap: var(--space-sm); font-size: var(--text-sm); color: var(--ink-muted); flex-wrap: wrap; }
.conf-detail > span, .conf-link { display: inline-flex; align-items: center; gap: var(--space-2xs); }
.conf-topics { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
.conf-link { font-size: var(--text-sm); color: var(--accent); font-weight: var(--weight-medium); margin-top: auto; }
.conf-link:hover { text-decoration: underline; }
</style>

<template>
  <div class="category-tab">
    <h2 class="section-title">Datasets & Benchmarks</h2>
    <div class="card-grid">
      <a v-for="ds in DATASETS" :key="ds.name" :href="ds.url" target="_blank" rel="noopener" class="dataset-card card">
        <div class="ds-header">
          <span class="ds-source">{{ ds.source }}</span>
          <span class="badge">{{ ds.area }}</span>
        </div>
        <div class="ds-name">{{ ds.name }}</div>
        <div class="muted">{{ ds.desc }}</div>
        <div class="ds-tags">
          <span v-for="t in ds.tags" :key="t" class="tag">{{ t }}</span>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { AreaId } from '@/types'
defineProps<{ areaId: AreaId }>()

const DATASETS = [
  { name: 'FinanceBench', source: 'Patronus AI', url: 'https://github.com/patronus-ai/financebench', desc: 'Financial Q&A benchmark', area: 'finance', tags: ['QA', 'LLM', 'finance'] },
  { name: 'FNSPID', source: 'HuggingFace', url: 'https://huggingface.co/datasets/Zihan1004/FNSPID', desc: 'Financial News & Stock Price Integration', area: 'quant', tags: ['NLP', 'stocks', 'news'] },
  { name: 'HuggingFace Finance Datasets', source: 'HuggingFace', url: 'https://huggingface.co/datasets?search=finance', desc: 'Curated finance datasets', area: 'ai', tags: ['NLP', 'finance', 'LLM'] },
  { name: 'Awesome FinRL', source: 'GitHub', url: 'https://github.com/AI4Finance-Foundation/FinRL-Tutorials', desc: 'RL for finance tutorials', area: 'quant', tags: ['RL', 'trading', 'tutorial'] },
  { name: 'EDGAR', source: 'SEC', url: 'https://efts.sec.gov/LATEST/search-index?q=%22form-type%22%3A%2210-K%22', desc: 'SEC financial filings', area: 'finance', tags: ['SEC', '10-K', 'filings'] },
  { name: 'FRED Economic Data', source: 'St. Louis Fed', url: 'https://fred.stlouisfed.org', desc: 'US macroeconomic data', area: 'market', tags: ['macro', 'economic', 'time-series'] },
  { name: 'Quandl / Nasdaq Data Link', source: 'Nasdaq', url: 'https://data.nasdaq.com', desc: 'Financial and alternative data', area: 'quant', tags: ['market-data', 'alternative', 'quant'] },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.dataset-card { display: flex; flex-direction: column; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); }
.ds-header { display: flex; align-items: center; justify-content: space-between; }
.ds-source { font-size: var(--text-xs); color: var(--ink-muted); font-weight: var(--weight-medium); }
.ds-name { font-weight: var(--weight-bold); }
.ds-tags { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

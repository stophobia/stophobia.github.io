<template>
  <div class="category-tab">
    <h2 class="tab-section-title">📊 Datasets & Benchmarks</h2>
    <div class="datasets-grid">
      <a v-for="ds in DATASETS" :key="ds.name" :href="ds.url" target="_blank" rel="noopener" class="dataset-card card">
        <div class="ds-header">
          <span class="ds-source">{{ ds.source }}</span>
          <span class="badge" :class="`badge-${ds.area}`">{{ ds.area }}</span>
        </div>
        <div class="ds-name">{{ ds.name }}</div>
        <div class="ds-desc">{{ ds.desc }}</div>
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
  { name: 'FinanceBench', source: 'JPMorgan', url: 'https://github.com/patronasnetworks/financebench', desc: 'Financial Q&A benchmark', area: 'finance', tags: ['QA', 'LLM', 'finance'] },
  { name: 'FNSPID', source: 'Kaggle', url: 'https://www.kaggle.com', desc: 'Financial News & Stock Price Integration', area: 'quant', tags: ['NLP', 'stocks', 'news'] },
  { name: 'HuggingFace Finance Datasets', source: 'HuggingFace', url: 'https://huggingface.co/datasets?search=finance', desc: 'Curated finance datasets', area: 'ai', tags: ['NLP', 'finance', 'LLM'] },
  { name: 'Awesome FinRL', source: 'GitHub', url: 'https://github.com/AI4Finance-Foundation/FinRL-Tutorials', desc: 'RL for finance tutorials', area: 'quant', tags: ['RL', 'trading', 'tutorial'] },
  { name: 'EDGAR', source: 'SEC', url: 'https://efts.sec.gov/LATEST/search-index?q=%22form-type%22%3A%2210-K%22', desc: 'SEC financial filings', area: 'finance', tags: ['SEC', '10-K', 'filings'] },
  { name: 'FRED Economic Data', source: 'St. Louis Fed', url: 'https://fred.stlouisfed.org', desc: 'US macroeconomic data', area: 'market', tags: ['macro', 'economic', 'time-series'] },
  { name: 'Quandl / Nasdaq Data Link', source: 'Nasdaq', url: 'https://data.nasdaq.com', desc: 'Financial and alternative data', area: 'quant', tags: ['market-data', 'alternative', 'quant'] },
  { name: 'Papers with Code Datasets', source: 'PwC', url: 'https://paperswithcode.com/datasets', desc: 'ML benchmark datasets', area: 'research', tags: ['ML', 'benchmark', 'AI'] },
]
</script>

<style scoped>
.category-tab { display: flex; flex-direction: column; gap: 16px; }
.tab-section-title { font-size: 18px; font-weight: 700; }
.datasets-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px; }
.dataset-card { display: flex; flex-direction: column; gap: 8px; padding: 16px; }
.ds-header { display: flex; align-items: center; justify-content: space-between; }
.ds-source { font-size: 11px; color: var(--text-muted); font-weight: 500; }
.ds-name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
.ds-desc { font-size: 12px; color: var(--text-secondary); }
.ds-tags { display: flex; gap: 4px; flex-wrap: wrap; }
</style>

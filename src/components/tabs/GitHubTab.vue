<template>
  <div class="github-tab">
    <div class="github-sub-tabs">
      <button
        v-for="sub in subTabs"
        :key="sub.id"
        class="chip"
        :class="{ active: activeSub === sub.id }"
        @click="activeSub = sub.id"
      >
        <span class="material-symbols-outlined" aria-hidden="true">{{ sub.icon }}</span>
        {{ sub.label }}
      </button>
    </div>

    <!-- Trending -->
    <div v-if="activeSub === 'trending'">
      <div class="card-grid">
        <a
          v-for="event in trendingEvents"
          :key="event.id"
          :href="event.url"
          target="_blank"
          rel="noopener"
          class="gh-repo-card card"
        >
          <div class="gh-repo-header">
            <span class="gh-repo-name">{{ event.title }}</span>
            <div class="gh-repo-stats">
              <span><span class="material-symbols-outlined" aria-hidden="true">star</span> {{ formatNumber(event.stars ?? 0) }}</span>
              <span><span class="material-symbols-outlined" aria-hidden="true">fork_right</span> {{ formatNumber(event.forks ?? 0) }}</span>
            </div>
          </div>
          <p class="gh-repo-desc muted">{{ event.summary }}</p>
          <div class="gh-repo-footer">
            <span class="gh-age muted">{{ relativeTime(event.publishedAt) }}</span>
            <div class="gh-tags">
              <span v-for="tag in (event.tags || []).slice(2, 5)" :key="tag" class="tag">{{ tag }}</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Releases -->
    <div v-if="activeSub === 'releases'">
      <FeedGrid :area-id="areaId" :override-categories="['github_release']" hide-filter />
    </div>

    <!-- Tracked Repos -->
    <div v-if="activeSub === 'watched'">
      <div class="card-grid">
        <a
          v-for="repo in WATCHED_REPOS"
          :key="repo.url"
          :href="repo.url"
          target="_blank"
          rel="noopener"
          class="gh-watch-item card"
        >
          <div class="gh-watch-name">{{ repo.name }}</div>
          <div class="muted">{{ repo.desc }}</div>
          <div class="gh-watch-tags">
            <span v-for="t in repo.tags" :key="t" class="tag">{{ t }}</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useFeedStore } from '@/stores/feedStore'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'

defineProps<{ areaId: AreaId }>()
const feedStore = useFeedStore()
const activeSub = ref<'trending' | 'releases' | 'watched'>('trending')

const subTabs = [
  { id: 'trending' as const, icon: 'local_fire_department', label: 'Trending Repos' },
  { id: 'releases' as const, icon: 'sell', label: 'Releases' },
  { id: 'watched' as const, icon: 'visibility', label: 'Watched Projects' },
]

const WATCHED_REPOS = [
  { name: 'langchain-ai/langchain', url: 'https://github.com/langchain-ai/langchain', desc: 'LLM application framework', tags: ['LLM', 'agents', 'RAG'] },
  { name: 'langchain-ai/langgraph', url: 'https://github.com/langchain-ai/langgraph', desc: 'Graph-based agent orchestration', tags: ['agents', 'graph', 'LLM'] },
  { name: 'run-llama/llama_index', url: 'https://github.com/run-llama/llama_index', desc: 'Data framework for LLMs', tags: ['RAG', 'LLM', 'indexing'] },
  { name: 'vllm-project/vllm', url: 'https://github.com/vllm-project/vllm', desc: 'High-throughput LLM serving', tags: ['inference', 'LLM', 'performance'] },
  { name: 'microsoft/autogen', url: 'https://github.com/microsoft/autogen', desc: 'Multi-agent conversation framework', tags: ['agents', 'multi-agent'] },
  { name: 'AI4Finance-Foundation/FinRL', url: 'https://github.com/AI4Finance-Foundation/FinRL', desc: 'Deep RL for finance', tags: ['RL', 'trading', 'quant'] },
  { name: 'microsoft/qlib', url: 'https://github.com/microsoft/qlib', desc: 'AI-oriented quantitative investment platform', tags: ['quant', 'AI', 'trading'] },
  { name: 'huggingface/transformers', url: 'https://github.com/huggingface/transformers', desc: 'State-of-the-art ML models', tags: ['LLM', 'transformers', 'ML'] },
  { name: 'OpenHands/OpenHands', url: 'https://github.com/OpenHands/OpenHands', desc: 'Open platform for AI software agents', tags: ['agents', 'coding', 'AI'] },
  { name: 'ray-project/ray', url: 'https://github.com/ray-project/ray', desc: 'Distributed computing framework', tags: ['distributed', 'ML', 'scalability'] },
  { name: 'ml-explore/mlx', url: 'https://github.com/ml-explore/mlx', desc: 'Array framework for Apple silicon', tags: ['Apple', 'ML', 'inference'] },
  { name: 'feast-dev/feast', url: 'https://github.com/feast-dev/feast', desc: 'Open-source feature store', tags: ['MLOps', 'features', 'data'] },
]

const trendingEvents = computed(() =>
  feedStore.events
    .filter((e) => e.source === 'GitHub Trending') // person repos are also github_repo
    .sort((a, b) => (b.stars ?? 0) - (a.stars ?? 0))
    .slice(0, 20),
)

function formatNumber(n: number): string {
  if (n >= 1000) return `${(n / 1000).toFixed(1)}k`
  return String(n)
}

function relativeTime(iso: string): string {
  const diff = Date.now() - new Date(iso).getTime()
  if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`
  return `${Math.floor(diff / 86400000)}d ago`
}
</script>

<style scoped>
.github-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.github-sub-tabs { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }

.gh-repo-card,
.gh-watch-item { display: flex; flex-direction: column; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); }

.gh-repo-header,
.gh-repo-footer { display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-xs); }

/* Repo names are identifiers: mono makes owner/name easy to compare */
.gh-repo-name,
.gh-watch-name { font-family: var(--font-mono); font-size: var(--text-sm); font-weight: var(--weight-medium); color: var(--accent); }
.gh-repo-name { flex: 1; overflow-wrap: anywhere; }

.gh-repo-stats { display: flex; gap: var(--space-xs); font-size: var(--text-xs); color: var(--ink-muted); flex-shrink: 0; }
.gh-repo-stats > span { display: flex; align-items: center; gap: var(--space-3xs); }

.gh-repo-desc {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.gh-age { white-space: nowrap; }

.gh-tags,
.gh-watch-tags { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
</style>

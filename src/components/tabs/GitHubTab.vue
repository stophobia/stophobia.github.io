<template>
  <div class="github-tab">
    <div class="github-sub-tabs">
      <button
        v-for="sub in subTabs"
        :key="sub.id"
        class="github-sub-tab"
        :class="{ active: activeSub === sub.id }"
        @click="activeSub = sub.id"
      >
        {{ sub.icon }} {{ sub.label }}
      </button>
    </div>

    <!-- Trending -->
    <div v-if="activeSub === 'trending'">
      <div v-if="loading" class="gh-loading">
        <div class="spinner"></div>
        <span>Fetching trending repos…</span>
      </div>
      <div v-else class="gh-repos-grid">
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
              <span>⭐ {{ formatNumber(event.stars ?? 0) }}</span>
              <span>🍴 {{ formatNumber(event.forks ?? 0) }}</span>
            </div>
          </div>
          <p class="gh-repo-desc">{{ event.summary }}</p>
          <div class="gh-repo-footer">
            <span class="gh-age">{{ relativeTime(event.publishedAt) }}</span>
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
    <div v-if="activeSub === 'watched'" class="gh-watched">
      <div class="gh-watched-grid">
        <a
          v-for="repo in WATCHED_REPOS"
          :key="repo.url"
          :href="repo.url"
          target="_blank"
          rel="noopener"
          class="gh-watch-item card"
        >
          <div class="gh-watch-name">{{ repo.name }}</div>
          <div class="gh-watch-desc">{{ repo.desc }}</div>
          <div class="gh-watch-tags">
            <span v-for="t in repo.tags" :key="t" class="tag">{{ t }}</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useFeedStore } from '@/stores/feedStore'
import FeedGrid from '@/components/feed/FeedGrid.vue'
import type { AreaId } from '@/types'

defineProps<{ areaId: AreaId }>()
const feedStore = useFeedStore()
const activeSub = ref<'trending' | 'releases' | 'watched'>('trending')
const loading = ref(false)

const subTabs = [
  { id: 'trending' as const, icon: '🔥', label: 'Trending Repos' },
  { id: 'releases' as const, icon: '🏷️', label: 'Releases' },
  { id: 'watched' as const, icon: '👁️', label: 'Watched Projects' },
]

const WATCHED_REPOS = [
  { name: 'langchain-ai/langchain', url: 'https://github.com/langchain-ai/langchain', desc: 'LLM application framework', tags: ['LLM', 'agents', 'RAG'] },
  { name: 'langchain-ai/langgraph', url: 'https://github.com/langchain-ai/langgraph', desc: 'Graph-based agent orchestration', tags: ['agents', 'graph', 'LLM'] },
  { name: 'run-llama/llama_index', url: 'https://github.com/run-llama/llama_index', desc: 'Data framework for LLMs', tags: ['RAG', 'LLM', 'indexing'] },
  { name: 'vllm-project/vllm', url: 'https://github.com/vllm-project/vllm', desc: 'High-throughput LLM serving', tags: ['inference', 'LLM', 'performance'] },
  { name: 'microsoft/autogen', url: 'https://github.com/microsoft/autogen', desc: 'Multi-agent conversation framework', tags: ['agents', 'multi-agent'] },
  { name: 'FinRL-Library/FinRL', url: 'https://github.com/FinRL-Library/FinRL', desc: 'Deep RL for finance', tags: ['RL', 'trading', 'quant'] },
  { name: 'microsoft/qlib', url: 'https://github.com/microsoft/qlib', desc: 'AI-oriented quantitative investment platform', tags: ['quant', 'AI', 'trading'] },
  { name: 'huggingface/transformers', url: 'https://github.com/huggingface/transformers', desc: 'State-of-the-art ML models', tags: ['LLM', 'transformers', 'ML'] },
  { name: 'All-Hands-AI/OpenHands', url: 'https://github.com/All-Hands-AI/OpenHands', desc: 'Open platform for AI software agents', tags: ['agents', 'coding', 'AI'] },
  { name: 'ray-project/ray', url: 'https://github.com/ray-project/ray', desc: 'Distributed computing framework', tags: ['distributed', 'ML', 'scalability'] },
]

const trendingEvents = computed(() =>
  feedStore.events
    .filter((e) => e.category === 'github_repo')
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
.github-tab { display: flex; flex-direction: column; gap: 16px; }

.github-sub-tabs { display: flex; gap: 6px; flex-wrap: wrap; }

.github-sub-tab {
  padding: 7px 14px;
  border-radius: var(--radius-sm);
  font-size: 13px;
  font-weight: 500;
  color: var(--text-muted);
  border: 1px solid var(--border-subtle);
  background: var(--bg-elevated);
  transition: all var(--transition-fast);
}
.github-sub-tab:hover { color: var(--text-primary); border-color: var(--border-default); }
.github-sub-tab.active { color: white; background: var(--bg-overlay); border-color: var(--border-strong); }

.gh-loading {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 24px;
  color: var(--text-muted);
  font-size: 13px;
}

.gh-repos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 12px;
}

.gh-repo-card {
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding: 14px;
}

.gh-repo-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
}

.gh-repo-name {
  font-size: 13px;
  font-weight: 600;
  color: #818cf8;
  font-family: var(--font-mono);
  flex: 1;
}

.gh-repo-stats {
  display: flex;
  gap: 8px;
  font-size: 11px;
  color: var(--text-muted);
  flex-shrink: 0;
}

.gh-repo-desc {
  font-size: 12px;
  color: var(--text-secondary);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.gh-repo-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}

.gh-age { font-size: 11px; color: var(--text-muted); }
.gh-tags { display: flex; gap: 4px; flex-wrap: wrap; }

/* Watched */
.gh-watched-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 10px;
}

.gh-watch-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
  padding: 14px;
}

.gh-watch-name {
  font-size: 12px;
  font-weight: 600;
  color: #818cf8;
  font-family: var(--font-mono);
}

.gh-watch-desc {
  font-size: 12px;
  color: var(--text-secondary);
}

.gh-watch-tags { display: flex; gap: 4px; flex-wrap: wrap; }
</style>

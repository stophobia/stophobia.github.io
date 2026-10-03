<template>
  <a
    :href="event.url"
    target="_blank"
    rel="noopener noreferrer"
    class="event-card card"
  >
    <!-- Thumbnail -->
    <div v-if="event.thumbnail" class="event-thumb">
      <img :src="event.thumbnail" :alt="event.title" loading="lazy" />
    </div>

    <div class="event-body">
      <!-- Top meta -->
      <div class="event-meta">
        <!-- Source logo + name -->
        <div class="event-source">
          <img
            v-if="event.sourceLogo"
            :src="event.sourceLogo"
            :alt="event.source"
            class="source-logo"
            @error="($event.target as HTMLImageElement).style.display = 'none'"
          />
          <span class="source-name">{{ event.source }}</span>
        </div>
        <!-- Category badge -->
        <span class="badge">{{ categoryLabel }}</span>
        <!-- Age -->
        <span class="event-age">{{ relativeTime }}</span>
      </div>

      <!-- Title -->
      <h3 class="event-title">{{ event.title }}</h3>

      <!-- Summary -->
      <p v-if="event.summary" class="event-summary">{{ event.summary }}</p>

      <!-- Footer -->
      <div class="event-footer">
        <!-- Author -->
        <div v-if="event.author" class="event-author">
          <img
            v-if="event.authorAvatar"
            :src="event.authorAvatar"
            :alt="event.author"
            class="author-avatar"
            @error="($event.target as HTMLImageElement).style.display = 'none'"
          />
          <span class="author-name">{{ event.author }}</span>
        </div>

        <!-- Stars/Forks for GitHub -->
        <div v-if="event.stars !== undefined" class="event-stats">
          <span><span class="material-symbols-outlined" aria-hidden="true">star</span> {{ formatNumber(event.stars) }}</span>
          <span><span class="material-symbols-outlined" aria-hidden="true">fork_right</span> {{ formatNumber(event.forks ?? 0) }}</span>
        </div>

        <!-- Tags -->
        <div class="event-tags">
          <span
            v-for="tag in (event.tags || []).slice(0, 3)"
            :key="tag"
            class="tag"
          >{{ tag }}</span>
        </div>
      </div>
    </div>
  </a>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { FeedEvent } from '@/types'

const props = defineProps<{ event: FeedEvent }>()

const CATEGORY_LABELS: Record<string, string> = {
  paper: 'Paper',
  github_release: 'Release',
  github_repo: 'Repo',
  blog_post: 'Blog',
  news: 'News',
  video: 'Video',
  podcast: 'Podcast',
  tweet: 'Post',
  regulation: 'Regulation',
  conference: 'Conference',
  dataset: 'Dataset',
  tool: 'Tool',
  job: 'Job',
  discussion: 'Discussion',
  strategy: 'Strategy',
}

const categoryLabel = computed(() => CATEGORY_LABELS[props.event.category] || props.event.category)

const relativeTime = computed(() => {
  const now = Date.now()
  const then = new Date(props.event.publishedAt).getTime()
  const diff = now - then
  if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`
  if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`
  if (diff < 7 * 86400000) return `${Math.floor(diff / 86400000)}d ago`
  return new Date(props.event.publishedAt).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
})

function formatNumber(n: number): string {
  if (n >= 1000) return `${(n / 1000).toFixed(1)}k`
  return String(n)
}
</script>

<style scoped>
.event-card {
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.event-thumb {
  height: 8.75rem;
  border-bottom: 1px solid var(--border);
}

.event-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.event-body {
  padding: var(--space-sm) var(--space-md);
  display: flex;
  flex-direction: column;
  gap: var(--space-xs);
  flex: 1;
}

.event-meta,
.event-footer {
  display: flex;
  align-items: center;
  gap: var(--space-xs);
  flex-wrap: wrap;
  font-size: var(--text-xs);
  color: var(--ink-muted);
}

.event-source,
.event-author,
.event-stats,
.event-stats > span {
  display: flex;
  align-items: center;
  gap: var(--space-2xs);
}

.event-stats { gap: var(--space-xs); }

.source-logo {
  width: 0.875rem;
  height: 0.875rem;
  object-fit: contain;
}

.source-name { font-weight: var(--weight-medium); }

.event-age {
  margin-left: auto;
  font-variant-numeric: tabular-nums;
}

.event-title {
  font-size: var(--text-md);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.event-card:hover .event-title { color: var(--accent); }

.event-summary {
  font-size: var(--text-sm);
  color: var(--ink-muted);
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.event-footer { margin-top: auto; }

.author-avatar {
  width: 1.125rem;
  height: 1.125rem;
  border-radius: var(--radius-full);
  object-fit: cover;
}

.event-tags {
  display: flex;
  gap: var(--space-2xs);
  flex-wrap: wrap;
  margin-left: auto;
}
</style>

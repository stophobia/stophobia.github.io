<template>
  <a
    :href="event.url"
    target="_blank"
    rel="noopener noreferrer"
    class="event-card card"
    :class="`event-card--${event.category}`"
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
        <span class="badge" :class="categoryBadgeClass">{{ categoryLabel }}</span>
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
          <span>⭐ {{ formatNumber(event.stars) }}</span>
          <span>🍴 {{ formatNumber(event.forks ?? 0) }}</span>
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
}

const CATEGORY_BADGE_CLASS: Record<string, string> = {
  paper: 'badge-paper',
  github_release: 'badge-github',
  github_repo: 'badge-github',
  blog_post: 'badge-ai',
  news: 'badge-news',
  video: 'badge-video',
  podcast: 'badge-quant',
  regulation: 'badge-finance',
  dataset: 'badge-research',
  tool: 'badge-quant',
}

const categoryLabel = computed(() => CATEGORY_LABELS[props.event.category] || props.event.category)
const categoryBadgeClass = computed(() => CATEGORY_BADGE_CLASS[props.event.category] || 'badge-ai')

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
  padding: 0;
  overflow: hidden;
  cursor: pointer;
  transition: all var(--transition-fast);
  position: relative;
}

.event-card::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: var(--radius-md);
  opacity: 0;
  transition: opacity var(--transition-fast);
  pointer-events: none;
}

.event-card:hover::after { opacity: 1; }

/* Category-based left accent */
.event-card::before {
  content: '';
  position: absolute;
  left: 0;
  top: 12px;
  bottom: 12px;
  width: 2px;
  border-radius: 2px;
  opacity: 0;
  transition: opacity var(--transition-fast);
}

.event-card:hover::before { opacity: 1; }

.event-card--paper::before       { background: #c084fc; }
.event-card--github_release::before { background: #94a3b8; }
.event-card--github_repo::before { background: #94a3b8; }
.event-card--blog_post::before   { background: #818cf8; }
.event-card--news::before        { background: #fca5a5; }
.event-card--video::before       { background: #f87171; }
.event-card--regulation::before  { background: #34d399; }

/* Thumbnail */
.event-thumb {
  width: 100%;
  height: 140px;
  overflow: hidden;
}

.event-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-slow);
}

.event-card:hover .event-thumb img { transform: scale(1.03); }

/* Body */
.event-body {
  padding: 14px 16px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex: 1;
}

/* Meta */
.event-meta {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.event-source {
  display: flex;
  align-items: center;
  gap: 5px;
}

.source-logo {
  width: 14px;
  height: 14px;
  border-radius: 3px;
  object-fit: contain;
}

.source-name {
  font-size: 11px;
  color: var(--text-muted);
  font-weight: 500;
}

.event-age {
  font-size: 11px;
  color: var(--text-muted);
  margin-left: auto;
  font-variant-numeric: tabular-nums;
  flex-shrink: 0;
}

/* Title */
.event-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-primary);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  transition: color var(--transition-fast);
}

.event-card:hover .event-title { color: #a5b4fc; }

/* Summary */
.event-summary {
  font-size: 12px;
  color: var(--text-secondary);
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Footer */
.event-footer {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: auto;
}

.event-author {
  display: flex;
  align-items: center;
  gap: 5px;
}

.author-avatar {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  object-fit: cover;
}

.author-name {
  font-size: 11px;
  color: var(--text-muted);
}

.event-stats {
  display: flex;
  gap: 8px;
  font-size: 11px;
  color: var(--text-muted);
}

.event-tags {
  display: flex;
  gap: 4px;
  flex-wrap: wrap;
  margin-left: auto;
}
</style>

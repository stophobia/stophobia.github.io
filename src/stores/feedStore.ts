import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { FeedEvent, FilterState, SortMode, AreaId } from '@/types'

// Generated at build time by scripts/collect.ts
const FEED_URL = `${import.meta.env.BASE_URL}data/feed.json`

// Default topic filters, matched against title/summary/tags; these patterns also catch synonyms
export const TOPICS: Record<string, RegExp> = {
  LLM: /\b(LLMs?|language models?)\b/i,
  Agent: /\bagent(s|ic)?\b/i,
  RAG: /\b(RAG|retrieval[- ]augmented)\b/i,
  MCP: /\b(MCP|model context protocol)\b/i,
  RL: /\b(RL|RLHF|reinforcement learning)\b/i,
  Trading: /\b(trading|backtest\w*|alpha|portfolio)\b/i,
}

// A topic added in the editor matches as a whole word
const topicPattern = (name: string) =>
  Object.hasOwn(TOPICS, name) ? TOPICS[name] : new RegExp(`(?<!\\w)${name.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}(?!\\w)`, 'i')

const TOPICS_KEY = 'topics'
function loadTopics(): string[] {
  try {
    const list = JSON.parse(localStorage.getItem(TOPICS_KEY) || 'null')
    return Array.isArray(list) ? list : Object.keys(TOPICS)
  } catch {
    return Object.keys(TOPICS)
  }
}

// True when one of fields contains query, ignoring case; a blank query matches anything
export function matches(query: string, fields: (string | undefined)[]) {
  const q = query.trim().toLowerCase()
  return !q || fields.some((f) => f?.toLowerCase().includes(q))
}

// What a search looks through in an event
export const eventFields = (e: FeedEvent) => [e.title, e.summary, e.source, e.author, e.organization, ...e.tags]

export const useFeedStore = defineStore('feed', () => {
  const events = ref<FeedEvent[]>([])
  const isLoading = ref(false)
  const isRefreshing = ref(false)
  const error = ref<string | null>(null)
  const lastFetchedAt = ref<number | null>(null)

  const filter = ref<FilterState>({
    timeRange: 'all',
    area: null,
    categories: [],
    tags: [],
    query: '',
  })

  const sortMode = ref<SortMode>('latest')

  // The filter bar shows topics; the editor saves savedTopics, which the next fetchFeeds brings in
  const topics = ref(loadTopics())
  const savedTopics = ref(topics.value)

  function saveTopics(list: string[]) {
    savedTopics.value = list
    try {
      localStorage.setItem(TOPICS_KEY, JSON.stringify(list))
    } catch {
      // ponytail: storage blocked (private window); the edit still applies for this visit
    }
  }

  function setFilter(partial: Partial<FilterState>) {
    filter.value = { ...filter.value, ...partial }
  }

  function setSortMode(mode: SortMode) {
    sortMode.value = mode
  }

  const filtered = computed(() => {
    let result = events.value

    // Time range filter
    if (filter.value.timeRange !== 'all') {
      const cutoff = {
        today: Date.now() - 86400_000,
        week: Date.now() - 7 * 86400_000,
        month: Date.now() - 30 * 86400_000,
        all: 0,
      }[filter.value.timeRange]
      result = result.filter((e) => new Date(e.publishedAt).getTime() >= cutoff)
    }

    // Area filter
    if (filter.value.area) {
      result = result.filter((e) => e.area.includes(filter.value.area as AreaId))
    }

    // Category filter
    if (filter.value.categories.length) {
      result = result.filter((e) => filter.value.categories.includes(e.category))
    }

    // Topic filter
    if (filter.value.tags.length) {
      const patterns = filter.value.tags.map(topicPattern)
      result = result.filter((e) => {
        const text = `${e.title} ${e.summary} ${e.tags.join(' ')}`
        return patterns.some((re) => re.test(text))
      })
    }

    // Search query
    if (filter.value.query.trim()) {
      result = result.filter((e) => matches(filter.value.query, eventFields(e)))
    }

    // Sort
    if (sortMode.value === 'latest') {
      result = [...result].sort(
        (a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime(),
      )
    } else if (sortMode.value === 'score') {
      result = [...result].sort((a, b) => (b.score ?? 0) - (a.score ?? 0))
    }

    return result
  })

  const byArea = computed(() => {
    const map: Record<string, FeedEvent[]> = {}
    for (const e of events.value) {
      for (const a of e.area) {
        if (!map[a]) map[a] = []
        map[a].push(e)
      }
    }
    return map
  })

  async function fetchFeeds() {
    if (isLoading.value || isRefreshing.value) return

    if (events.value.length === 0) {
      isLoading.value = true
    } else {
      isRefreshing.value = true
    }
    error.value = null

    try {
      const resp = await fetch(FEED_URL, { cache: 'no-cache' })
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`)
      const data: { generatedAt: number; events: FeedEvent[] } = await resp.json()
      events.value = data.events
      lastFetchedAt.value = data.generatedAt
      topics.value = savedTopics.value
      setFilter({ tags: filter.value.tags.filter((t) => topics.value.includes(t)) })
    } catch (e: unknown) {
      error.value = e instanceof Error ? e.message : 'Unknown error'
    } finally {
      isLoading.value = false
      isRefreshing.value = false
    }
  }

  return {
    events,
    isLoading,
    isRefreshing,
    error,
    lastFetchedAt,
    filter,
    sortMode,
    topics,
    savedTopics,
    filtered,
    byArea,
    setFilter,
    setSortMode,
    saveTopics,
    fetchFeeds,
  }
})

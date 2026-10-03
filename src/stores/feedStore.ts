import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { FeedEvent, FilterState, SortMode, AreaId } from '@/types'
import { fetchAllFeeds, RSS_FEEDS } from '@/services/rssCollector'
import { fetchGitHubReleases, fetchTrendingRepos } from '@/services/githubService'
import { fetchAllHuggingFace } from '@/services/huggingfaceService'

const CACHE_TTL_MS = 15 * 60 * 1000 // 15 minutes

export const useFeedStore = defineStore('feed', () => {
  const events = ref<FeedEvent[]>([])
  const isLoading = ref(false)
  const isRefreshing = ref(false)
  const error = ref<string | null>(null)
  const lastFetchedAt = ref<number | null>(null)

  const filter = ref<FilterState>({
    timeRange: 'week',
    area: null,
    categories: [],
    tags: [],
    query: '',
  })

  const sortMode = ref<SortMode>('latest')

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

    // Tag filter
    if (filter.value.tags.length) {
      result = result.filter((e) => filter.value.tags.some((t) => e.tags.includes(t)))
    }

    // Search query
    if (filter.value.query.trim()) {
      const q = filter.value.query.toLowerCase()
      result = result.filter(
        (e) =>
          e.title.toLowerCase().includes(q) ||
          e.summary.toLowerCase().includes(q) ||
          (e.author?.toLowerCase().includes(q) ?? false) ||
          (e.organization?.toLowerCase().includes(q) ?? false),
      )
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

  function isCacheStale(): boolean {
    if (!lastFetchedAt.value) return true
    return Date.now() - lastFetchedAt.value > CACHE_TTL_MS
  }

  async function fetchFeeds(force = false) {
    if (!force && !isCacheStale()) return
    if (isLoading.value || isRefreshing.value) return

    if (events.value.length === 0) {
      isLoading.value = true
    } else {
      isRefreshing.value = true
    }
    error.value = null

    try {
      const [rssEvents, ghReleases, ghTrending, hfEvents] = await Promise.allSettled([
        fetchAllFeeds(RSS_FEEDS),
        fetchGitHubReleases(),
        fetchTrendingRepos(),
        fetchAllHuggingFace(),
      ])

      const all: FeedEvent[] = []
      if (rssEvents.status === 'fulfilled') all.push(...rssEvents.value)
      if (ghReleases.status === 'fulfilled') all.push(...ghReleases.value)
      if (ghTrending.status === 'fulfilled') all.push(...ghTrending.value)
      if (hfEvents.status === 'fulfilled') all.push(...hfEvents.value)

      // Deduplicate by id
      const seen = new Set<string>()
      events.value = all.filter((e) => {
        if (seen.has(e.id)) return false
        seen.add(e.id)
        return true
      }).sort((a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime())

      lastFetchedAt.value = Date.now()
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
    filtered,
    byArea,
    setFilter,
    setSortMode,
    fetchFeeds,
  }
})

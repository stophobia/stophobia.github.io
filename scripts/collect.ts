/**
 * Build-time collector: fetches every source once and writes public/data/feed.json.
 * Run with `npm run collect` (Node 24 strips the TypeScript types natively).
 */
import { mkdirSync, writeFileSync } from 'node:fs'
import type { FeedEvent, Person } from '../src/types/index.ts'
import { RSS_FEEDS, arxivQuery, type RssFeedConfig } from '../src/data/feeds.ts'
import { PEOPLE } from '../src/data/people.ts'
import { fetchAllFeeds, fetchRssFeed } from '../src/services/rssCollector.ts'
import { HEADERS, fetchGitHubReleases, fetchTrendingRepos, fetchUserRepos } from '../src/services/githubService.ts'
import { fetchAllHuggingFace } from '../src/services/huggingfaceService.ts'

const DEPLOYED_FEED = 'https://stophobia.github.io/data/feed.json'

if (process.env.GITHUB_TOKEN) HEADERS.Authorization = `Bearer ${process.env.GITHUB_TOKEN}`

// Person timeline: own blog, arXiv papers, new GitHub repos — each event linked by personId
async function fetchPerson(p: Person): Promise<FeedEvent[]> {
  const base = { area: p.areas, tags: p.tags.slice(0, 2) }
  const feeds: RssFeedConfig[] = []
  if (p.blogFeed) feeds.push({ ...base, url: p.blogFeed, source: p.name, category: 'blog_post' })
  if (p.arxivAuthor) feeds.push({ ...base, url: arxivQuery(`au:"${p.arxivAuthor}"`, 5), source: 'arXiv', category: 'paper' })
  const login = p.links.github?.split('/').pop()
  const results = await Promise.all([...feeds.map(fetchRssFeed), login ? fetchUserRepos(login, p.areas) : []])
  return results.flat().map((e) => ({ ...e, personId: p.id }))
}

// People first so the dedupe below keeps their personId on papers also found by category
const results = await Promise.allSettled([
  Promise.all(PEOPLE.map(fetchPerson)).then((r) => r.flat()),
  fetchAllFeeds(RSS_FEEDS),
  fetchGitHubReleases(),
  fetchTrendingRepos(),
  fetchAllHuggingFace(),
])

const fresh = results.flatMap((r) => (r.status === 'fulfilled' ? r.value : []))

const counts: Record<string, number> = {}
for (const e of fresh) counts[e.source] = (counts[e.source] ?? 0) + 1
console.table(counts)

// Feeds can be empty for a while (arXiv skips weekends, YouTube/hnrss fail intermittently).
// Keep their items from the deployed feed instead of blanking the tab until the next run.
const missing = new Set(RSS_FEEDS.filter((f) => !counts[f.source]).map((f) => f.source))
let carried: FeedEvent[] = []
if (missing.size) {
  const prev = await fetch(DEPLOYED_FEED, { signal: AbortSignal.timeout(15_000) })
    .then((r) => (r.ok ? r.json() : { events: [] }))
    .catch(() => ({ events: [] }))
  carried = (prev.events as FeedEvent[]).filter((e) => missing.has(e.source))
  for (const source of missing) {
    const n = carried.filter((e) => e.source === source).length
    console.log(`::warning::${source}: 0 items this run, kept ${n} from the deployed feed`)
  }
}

const seen = new Set<string>()
const events = [...fresh, ...carried]
  .filter((e) => !seen.has(e.id) && seen.add(e.id))
  .sort((a, b) => b.publishedAt.localeCompare(a.publishedAt))

if (!events.length) {
  console.error('No events collected; keeping the previous deployment.')
  process.exit(1)
}

mkdirSync('public/data', { recursive: true })
writeFileSync('public/data/feed.json', JSON.stringify({ generatedAt: Date.now(), events }))
console.log(`Wrote ${events.length} events to public/data/feed.json`)

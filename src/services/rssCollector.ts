/**
 * RSS / Atom Feed Collector
 * Runs at build time (scripts/collect.ts) and parses feeds to FeedEvent[]
 */
import { XMLParser } from 'fast-xml-parser'
import type { FeedEvent } from '@/types'
import type { RssFeedConfig } from '@/data/feeds'

const USER_AGENT = 'stophobia.github.io feed collector (stophobia@gmail.com)' // SEC requires a contact in the UA
const MAX_ITEMS_PER_FEED = 20
const parser = new XMLParser({ ignoreAttributes: false, attributeNamePrefix: '', parseTagValue: false })

// Parsed XML is untyped: a node is a string, or an object with '#text' when it has attributes.
type XmlNode = any
const text = (v: XmlNode): string => String((v && typeof v === 'object' ? v['#text'] : v) ?? '').trim()
const list = (v: XmlNode): XmlNode[] => (v == null ? [] : Array.isArray(v) ? v : [v])

function stripHtml(html: string): string {
  return html.replace(/<[^>]*>/g, '').replace(/&[^;]+;/g, ' ').trim()
}

function generateId(url: string, publishedAt: string): string {
  const str = `${url}__${publishedAt}`
  let hash = 0
  for (let i = 0; i < str.length; i++) {
    const char = str.charCodeAt(i)
    hash = ((hash << 5) - hash) + char
    hash = hash & hash
  }
  return Math.abs(hash).toString(36)
}

function itemLink(it: XmlNode): string {
  // RSS: <link>url</link>; Atom: <link rel="alternate" href="url"/> (possibly several)
  for (const l of list(it.link)) {
    if (typeof l !== 'object') return text(l)
    if (!l.rel || l.rel === 'alternate') return l.href
  }
  return text(it.guid) || text(it.id)
}

export async function fetchRssFeed(config: RssFeedConfig): Promise<FeedEvent[]> {
  try {
    // YouTube and hnrss return spurious 404/5xx for valid feeds; retry a couple of times
    let resp: Response | undefined
    for (let attempt = 0; attempt < 3 && !resp?.ok; attempt++) {
      if (attempt) await new Promise((r) => setTimeout(r, 2000))
      resp = await fetch(config.url, {
        headers: { 'User-Agent': USER_AGENT },
        signal: AbortSignal.timeout(15_000),
      })
    }
    if (!resp?.ok) throw new Error(`HTTP ${resp?.status}`)
    const xml = parser.parse(await resp.text())
    const items = list(xml.rss?.channel?.item ?? xml['rdf:RDF']?.item ?? xml.feed?.entry)

    return items.slice(0, MAX_ITEMS_PER_FEED).flatMap((it): FeedEvent[] => {
      // Japan FSA uses "JST", which Date cannot parse
      const rawDate = text(it.pubDate ?? it.published ?? it.updated ?? it['dc:date']).replace(/ JST$/, ' +0900')
      const date = new Date(rawDate)
      if (isNaN(date.getTime())) return [] // never fake "now": old items would look brand new
      const publishedAt = date.toISOString()
      const url = itemLink(it)
      const media = it['media:group'] ?? it
      const author = list(it.author)[0]
      const summary = stripHtml(
        text(it.description ?? it.summary ?? media['media:description'] ?? it['content:encoded'] ?? it.content),
      ).slice(0, 300)

      return [{
        id: generateId(url, publishedAt),
        title: stripHtml(text(it.title)).replace(/\s+/g, ' ') || '(Untitled)',
        summary,
        url,
        author: text(it['dc:creator'] ?? author?.name ?? author) || undefined,
        organization: config.source,
        organizationLogo: config.sourceLogo,
        orgId: config.orgId,
        category: config.category,
        area: config.area,
        tags: [...config.tags, ...list(it.category).map(text).filter(Boolean)],
        publishedAt,
        source: config.source,
        sourceLogo: config.sourceLogo,
        thumbnail: media['media:thumbnail']?.url || undefined,
      }]
    })
  } catch (e) {
    console.warn(`[RSS] Failed to fetch ${config.source}:`, e)
    return []
  }
}

export async function fetchAllFeeds(
  configs: RssFeedConfig[],
  concurrency = 6,
): Promise<FeedEvent[]> {
  const results: FeedEvent[] = []
  for (let i = 0; i < configs.length; i += concurrency) {
    const chunk = configs.slice(i, i + concurrency)
    const chunkResults = await Promise.allSettled(chunk.map(fetchRssFeed))
    for (const res of chunkResults) {
      if (res.status === 'fulfilled') results.push(...res.value)
    }
  }
  return results
}

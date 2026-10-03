/**
 * RSS Feed Collector
 * Fetches RSS/Atom feeds via CORS-friendly proxy and parses to FeedEvent[]
 */
import type { FeedEvent, EventCategory, AreaTag } from '@/types'

const RSS_PROXY = 'https://api.rss2json.com/v1/api.json?rss_url='
const CORSPROXY = 'https://corsproxy.io/?'

export interface RssFeedConfig {
  url: string
  source: string
  sourceLogo?: string
  area: AreaTag[]
  category: EventCategory
  tags: string[]
}

export const RSS_FEEDS: RssFeedConfig[] = [
  // AI Company Blogs
  {
    url: 'https://openai.com/blog/rss.xml',
    source: 'OpenAI Blog',
    sourceLogo: 'https://logo.clearbit.com/openai.com',
    area: ['ai'],
    category: 'blog_post',
    tags: ['OpenAI', 'GPT', 'ChatGPT'],
  },
  {
    url: 'https://www.anthropic.com/rss.xml',
    source: 'Anthropic Blog',
    sourceLogo: 'https://logo.clearbit.com/anthropic.com',
    area: ['ai'],
    category: 'blog_post',
    tags: ['Anthropic', 'Claude', 'AI-safety'],
  },
  {
    url: 'https://huggingface.co/blog/feed.xml',
    source: 'Hugging Face Blog',
    sourceLogo: 'https://logo.clearbit.com/huggingface.co',
    area: ['ai'],
    category: 'blog_post',
    tags: ['HuggingFace', 'transformers', 'open-source'],
  },
  {
    url: 'https://developer.nvidia.com/blog/feed',
    source: 'NVIDIA Developer Blog',
    sourceLogo: 'https://logo.clearbit.com/nvidia.com',
    area: ['ai'],
    category: 'blog_post',
    tags: ['NVIDIA', 'GPU', 'CUDA'],
  },
  {
    url: 'https://deepmind.google/blog/rss',
    source: 'Google DeepMind Blog',
    sourceLogo: 'https://logo.clearbit.com/deepmind.com',
    area: ['ai', 'research'],
    category: 'blog_post',
    tags: ['DeepMind', 'Gemini', 'AlphaFold'],
  },
  {
    url: 'https://ai.meta.com/blog/rss',
    source: 'Meta AI Blog',
    sourceLogo: 'https://logo.clearbit.com/meta.com',
    area: ['ai'],
    category: 'blog_post',
    tags: ['Meta', 'LLaMA', 'PyTorch'],
  },
  // arXiv
  {
    url: 'https://rss.arxiv.org/rss/cs.AI',
    source: 'arXiv cs.AI',
    area: ['ai', 'research'],
    category: 'paper',
    tags: ['arXiv', 'AI', 'research'],
  },
  {
    url: 'https://rss.arxiv.org/rss/cs.LG',
    source: 'arXiv cs.LG',
    area: ['ai', 'research'],
    category: 'paper',
    tags: ['arXiv', 'machine-learning', 'research'],
  },
  {
    url: 'https://rss.arxiv.org/rss/q-fin',
    source: 'arXiv q-fin',
    area: ['quant', 'research', 'finance'],
    category: 'paper',
    tags: ['arXiv', 'quant-finance', 'research'],
  },
  // Finance News
  {
    url: 'https://feeds.bloomberg.com/technology/news.rss',
    source: 'Bloomberg Technology',
    sourceLogo: 'https://logo.clearbit.com/bloomberg.com',
    area: ['finance', 'ai'],
    category: 'news',
    tags: ['Bloomberg', 'finance', 'technology'],
  },
  {
    url: 'https://www.finextra.com/rss/headlines.aspx',
    source: 'Finextra',
    sourceLogo: 'https://logo.clearbit.com/finextra.com',
    area: ['finance'],
    category: 'news',
    tags: ['FinTech', 'banking', 'payments'],
  },
  // Quant / Community
  {
    url: 'https://quantocracy.com/feed',
    source: 'Quantocracy',
    area: ['quant'],
    category: 'strategy',
    tags: ['quant', 'trading', 'systematic'],
  },
  // Community
  {
    url: 'https://hnrss.org/frontpage',
    source: 'Hacker News',
    sourceLogo: 'https://news.ycombinator.com/favicon.ico',
    area: ['community', 'ai'],
    category: 'news',
    tags: ['HackerNews', 'tech', 'community'],
  },
]

interface Rss2JsonResponse {
  status: string
  feed: {
    title: string
    link: string
    image: string
    description: string
  }
  items: Array<{
    title: string
    pubDate: string
    link: string
    guid: string
    author: string
    description: string
    content: string
    thumbnail: string
    categories: string[]
  }>
}

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

export async function fetchRssFeed(config: RssFeedConfig): Promise<FeedEvent[]> {
  const proxyUrl = `${RSS_PROXY}${encodeURIComponent(config.url)}`
  try {
    const resp = await fetch(proxyUrl)
    if (!resp.ok) throw new Error(`HTTP ${resp.status}`)
    const data: Rss2JsonResponse = await resp.json()
    if (data.status !== 'ok') throw new Error('RSS parse failed')

    return data.items.map((item) => {
      const summary = stripHtml(item.description || item.content || '').slice(0, 300)
      const publishedAt = item.pubDate
        ? new Date(item.pubDate).toISOString()
        : new Date().toISOString()

      return {
        id: generateId(item.link || item.guid, publishedAt),
        title: item.title || '(Untitled)',
        summary,
        url: item.link || item.guid,
        author: item.author || undefined,
        organization: config.source,
        organizationLogo: config.sourceLogo,
        category: config.category,
        area: config.area,
        tags: [...config.tags, ...(item.categories || [])],
        publishedAt,
        source: config.source,
        sourceLogo: config.sourceLogo,
        thumbnail: item.thumbnail || undefined,
      } satisfies FeedEvent
    })
  } catch (e) {
    console.warn(`[RSS] Failed to fetch ${config.source}:`, e)
    return []
  }
}

export async function fetchAllFeeds(
  configs: RssFeedConfig[] = RSS_FEEDS,
  concurrency = 4,
): Promise<FeedEvent[]> {
  const results: FeedEvent[] = []
  for (let i = 0; i < configs.length; i += concurrency) {
    const chunk = configs.slice(i, i + concurrency)
    const chunkResults = await Promise.allSettled(chunk.map(fetchRssFeed))
    for (const res of chunkResults) {
      if (res.status === 'fulfilled') results.push(...res.value)
    }
  }
  return results.sort(
    (a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime(),
  )
}

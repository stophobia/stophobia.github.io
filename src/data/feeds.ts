import type { EventCategory, AreaTag } from '@/types'

// Pure data (no parser import) so the app can read it too; collected by scripts/collect.ts
export const favicon = (domain: string) => `https://www.google.com/s2/favicons?domain=${domain}&sz=64`
// arXiv API rather than its RSS: the RSS has no items on weekends and holidays
export const arxivQuery = (query: string, max = 20) =>
  `https://export.arxiv.org/api/query?search_query=${encodeURIComponent(query)}&sortBy=submittedDate&sortOrder=descending&max_results=${max}`
const YOUTUBE = 'https://www.youtube.com/feeds/videos.xml?channel_id='

export interface RssFeedConfig {
  url: string
  source: string
  sourceLogo?: string
  orgId?: string // links events to an ORGANIZATIONS entry
  area: AreaTag[]
  category: EventCategory
  tags: string[]
}

export const RSS_FEEDS: RssFeedConfig[] = [
  // AI Company Blogs
  {
    url: 'https://openai.com/blog/rss.xml',
    source: 'OpenAI Blog',
    orgId: 'openai',
    sourceLogo: favicon('openai.com'),
    area: ['ai'],
    category: 'blog_post',
    tags: ['OpenAI', 'GPT', 'ChatGPT'],
  },
  {
    // Anthropic has no official feed; community-generated (github.com/Olshansk/rss-feeds)
    url: 'https://raw.githubusercontent.com/Olshansk/rss-feeds/main/feeds/feed_anthropic_news.xml',
    source: 'Anthropic Blog',
    orgId: 'anthropic',
    sourceLogo: favicon('anthropic.com'),
    area: ['ai'],
    category: 'blog_post',
    tags: ['Anthropic', 'Claude', 'AI-safety'],
  },
  {
    url: 'https://huggingface.co/blog/feed.xml',
    source: 'Hugging Face Blog',
    orgId: 'hugging-face',
    sourceLogo: favicon('huggingface.co'),
    area: ['ai'],
    category: 'blog_post',
    tags: ['HuggingFace', 'transformers', 'open-source'],
  },
  {
    url: 'https://developer.nvidia.com/blog/feed',
    source: 'NVIDIA Developer Blog',
    orgId: 'nvidia',
    sourceLogo: favicon('nvidia.com'),
    area: ['ai'],
    category: 'blog_post',
    tags: ['NVIDIA', 'GPU', 'CUDA'],
  },
  {
    url: 'https://deepmind.google/blog/rss.xml',
    source: 'Google DeepMind Blog',
    orgId: 'google-deepmind',
    sourceLogo: favicon('deepmind.google'),
    area: ['ai', 'research'],
    category: 'blog_post',
    tags: ['DeepMind', 'Gemini', 'AlphaFold'],
  },
  {
    url: 'https://www.microsoft.com/en-us/research/feed/',
    source: 'Microsoft Research Blog',
    orgId: 'microsoft-research',
    sourceLogo: favicon('microsoft.com'),
    area: ['ai', 'research'],
    category: 'blog_post',
    tags: ['Microsoft', 'research'],
  },
  // arXiv
  {
    url: arxivQuery('cat:cs.AI'),
    source: 'arXiv cs.AI',
    orgId: 'arxiv',
    sourceLogo: favicon('arxiv.org'),
    area: ['ai', 'research'],
    category: 'paper',
    tags: ['arXiv', 'AI', 'research'],
  },
  {
    url: arxivQuery('cat:cs.LG'),
    source: 'arXiv cs.LG',
    orgId: 'arxiv',
    sourceLogo: favicon('arxiv.org'),
    area: ['ai', 'research'],
    category: 'paper',
    tags: ['arXiv', 'machine-learning', 'research'],
  },
  {
    url: arxivQuery('cat:q-fin.*'),
    source: 'arXiv q-fin',
    orgId: 'arxiv',
    sourceLogo: favicon('arxiv.org'),
    area: ['quant', 'research', 'finance'],
    category: 'paper',
    tags: ['arXiv', 'quant-finance', 'research'],
  },
  // Finance News
  {
    url: 'https://feeds.bloomberg.com/technology/news.rss',
    source: 'Bloomberg Technology',
    sourceLogo: favicon('bloomberg.com'),
    area: ['finance', 'ai'],
    category: 'news',
    tags: ['Bloomberg', 'finance', 'technology'],
  },
  {
    url: 'https://www.finextra.com/rss/headlines.aspx',
    source: 'Finextra',
    sourceLogo: favicon('finextra.com'),
    area: ['finance'],
    category: 'news',
    tags: ['FinTech', 'banking', 'payments'],
  },
  // Market News
  {
    url: 'https://fredblog.stlouisfed.org/feed/',
    source: 'FRED Blog',
    sourceLogo: favicon('stlouisfed.org'),
    area: ['market'],
    category: 'news',
    tags: ['FRED', 'macro', 'economic-data'],
  },
  {
    url: 'https://www.coindesk.com/arc/outboundfeeds/rss/',
    source: 'CoinDesk',
    sourceLogo: favicon('coindesk.com'),
    area: ['market'],
    category: 'news',
    tags: ['crypto', 'bitcoin', 'markets'],
  },
  // Regulators & Central Banks
  {
    url: 'https://www.sec.gov/news/pressreleases.rss',
    source: 'SEC',
    orgId: 'sec',
    sourceLogo: favicon('sec.gov'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['SEC', 'regulation', 'US'],
  },
  {
    url: 'https://www.cftc.gov/RSS/RSSGP/rssgp.xml',
    source: 'CFTC',
    orgId: 'cftc',
    sourceLogo: favicon('cftc.gov'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['CFTC', 'derivatives', 'US'],
  },
  {
    url: 'https://www.federalreserve.gov/feeds/press_all.xml',
    source: 'Federal Reserve',
    orgId: 'federal-reserve',
    sourceLogo: favicon('federalreserve.gov'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['Fed', 'monetary-policy', 'US'],
  },
  {
    url: 'https://www.ecb.europa.eu/rss/press.html',
    source: 'ECB',
    orgId: 'ecb',
    sourceLogo: favicon('ecb.europa.eu'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['ECB', 'monetary-policy', 'EU'],
  },
  {
    url: 'https://www.boj.or.jp/rss/whatsnew.xml',
    source: 'Bank of Japan',
    orgId: 'boj',
    sourceLogo: favicon('boj.or.jp'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['BOJ', 'monetary-policy', 'Japan'],
  },
  {
    url: 'https://www.fsa.go.jp/fsaNewsListAll_rss2.xml',
    source: 'Japan FSA',
    orgId: 'japan-fsa',
    sourceLogo: favicon('fsa.go.jp'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['FSA', 'regulation', 'Japan'],
  },
  {
    url: 'https://www.bis.org/doclist/bis_fsi_publs.rss',
    source: 'BIS FSI',
    orgId: 'bis',
    sourceLogo: favicon('bis.org'),
    area: ['finance', 'market'],
    category: 'regulation',
    tags: ['BIS', 'financial-stability', 'global'],
  },
  // Quant
  {
    url: 'https://quantocracy.com/feed',
    source: 'Quantocracy',
    sourceLogo: favicon('quantocracy.com'),
    area: ['quant'],
    category: 'strategy',
    tags: ['quant', 'trading', 'systematic'],
  },
  // Community
  {
    url: 'https://hnrss.org/frontpage',
    source: 'Hacker News',
    sourceLogo: favicon('news.ycombinator.com'),
    area: ['community', 'ai'],
    category: 'news',
    tags: ['HackerNews', 'tech', 'community'],
  },
  // Videos
  {
    url: `${YOUTUBE}UCbfYPyITQ-7l4upoX8nvctg`,
    source: 'Two Minute Papers',
    sourceLogo: favicon('youtube.com'),
    area: ['ai', 'research', 'community'],
    category: 'video',
    tags: ['YouTube', 'papers'],
  },
  {
    url: `${YOUTUBE}UCZHmQk67mSJgfCCTn7xBfew`,
    source: 'Yannic Kilcher',
    sourceLogo: favicon('youtube.com'),
    area: ['ai', 'research', 'community'],
    category: 'video',
    tags: ['YouTube', 'papers'],
  },
  {
    url: `${YOUTUBE}UCXUPKJO5MZQN11PqgIvyuvQ`,
    source: 'Andrej Karpathy YouTube',
    sourceLogo: favicon('youtube.com'),
    area: ['ai', 'community'],
    category: 'video',
    tags: ['YouTube', 'LLM'],
  },
  {
    url: `${YOUTUBE}UCXZCJLdBC09xxGZ6gcdrc6A`,
    source: 'OpenAI YouTube',
    orgId: 'openai',
    sourceLogo: favicon('youtube.com'),
    area: ['ai', 'community'],
    category: 'video',
    tags: ['YouTube', 'OpenAI'],
  },
  {
    url: `${YOUTUBE}UCIALMKvObZNtJ6AmdCLP7Lg`,
    source: 'Bloomberg Television',
    sourceLogo: favicon('youtube.com'),
    area: ['finance', 'market'],
    category: 'video',
    tags: ['YouTube', 'Bloomberg', 'markets'],
  },
  // Jobs
  {
    url: 'https://hnrss.org/jobs',
    source: 'HN Jobs',
    sourceLogo: favicon('news.ycombinator.com'),
    area: ['ai', 'community'],
    category: 'job',
    tags: ['jobs', 'startups'],
  },
  {
    url: 'https://hnrss.org/whoishiring/jobs?q=quant',
    source: 'HN Who is hiring (quant)',
    sourceLogo: favicon('news.ycombinator.com'),
    area: ['quant'],
    category: 'job',
    tags: ['jobs', 'quant'],
  },
  {
    url: 'https://hnrss.org/whoishiring/jobs?q=fintech',
    source: 'HN Who is hiring (fintech)',
    sourceLogo: favicon('news.ycombinator.com'),
    area: ['finance'],
    category: 'job',
    tags: ['jobs', 'fintech'],
  },
]

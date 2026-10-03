// ============================================================
// Core Domain Types — Financial AI Intelligence Hub
// ============================================================

export type AreaId = 'ai' | 'quant' | 'finance' | 'market' | 'research' | 'community'

export type TabId =
  | 'feed'
  | 'people'
  | 'organizations'
  | 'papers'
  | 'github'
  | 'news'
  | 'blog'
  | 'videos'
  | 'podcasts'
  | 'datasets'
  | 'tools'
  | 'conferences'
  | 'regulation'
  | 'strategies'
  | 'market-data'
  | 'jobs'

export type EventCategory =
  | 'paper'
  | 'github_release'
  | 'github_repo'
  | 'blog_post'
  | 'news'
  | 'video'
  | 'podcast'
  | 'tweet'
  | 'regulation'
  | 'conference'
  | 'dataset'
  | 'tool'
  | 'job'
  | 'discussion'
  | 'strategy'

export type AreaTag = AreaId

export interface FeedEvent {
  id: string
  title: string
  summary: string
  url: string
  author?: string
  authorAvatar?: string
  organization?: string
  organizationLogo?: string
  category: EventCategory
  area: AreaTag[]
  tags: string[]
  publishedAt: string // ISO 8601
  updatedAt?: string
  source: string
  sourceLogo?: string
  language?: string
  thumbnail?: string
  score?: number
  stars?: number
  forks?: number
  citations?: number
}

export interface Person {
  id: string
  name: string
  avatar?: string
  role: string
  organization: string
  areas: AreaTag[]
  tags: string[]
  bio: string
  links: {
    github?: string
    twitter?: string
    linkedin?: string
    website?: string
    scholar?: string
    arxiv?: string
  }
  recentEvents?: FeedEvent[]
}

export interface Organization {
  id: string
  name: string
  logo?: string
  type: 'ai_company' | 'hedge_fund' | 'asset_manager' | 'bank' | 'research' | 'regulator' | 'university' | 'fintech'
  areas: AreaTag[]
  description: string
  links: {
    website?: string
    github?: string
    blog?: string
    twitter?: string
    linkedin?: string
  }
  rssFeeds?: string[]
  tags: string[]
  recentEvents?: FeedEvent[]
}

export interface Area {
  id: AreaId
  label: string
  icon: string
  description: string
  color: string
  gradient: string
  tabs: TabId[]
}

export interface Tab {
  id: TabId
  label: string
  icon: string
}

export interface SearchResult {
  events: FeedEvent[]
  people: Person[]
  organizations: Organization[]
  total: number
}

export interface FilterState {
  timeRange: 'today' | 'week' | 'month' | 'all'
  area: AreaId | null
  categories: EventCategory[]
  tags: string[]
  query: string
}

export type SortMode = 'latest' | 'trending' | 'score'

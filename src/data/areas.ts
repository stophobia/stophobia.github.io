import type { Area, Tab } from '@/types'

// icon: a Google Material Symbols name (also listed in index.html)

export const TABS: Record<string, Tab> = {
  feed:          { id: 'feed',          label: 'Feed',          icon: 'dynamic_feed' },
  people:        { id: 'people',        label: 'People',        icon: 'group' },
  organizations: { id: 'organizations', label: 'Organizations', icon: 'corporate_fare' },
  papers:        { id: 'papers',        label: 'Research',      icon: 'description' },
  github:        { id: 'github',        label: 'GitHub',        icon: 'code' },
  news:          { id: 'news',          label: 'News',          icon: 'newspaper' },
  blog:          { id: 'blog',          label: 'Blog',          icon: 'edit_note' },
  videos:        { id: 'videos',        label: 'Videos',        icon: 'smart_display' },
  podcasts:      { id: 'podcasts',      label: 'Podcasts',      icon: 'podcasts' },
  datasets:      { id: 'datasets',      label: 'Datasets',      icon: 'dataset' },
  tools:         { id: 'tools',         label: 'Tools',         icon: 'build' },
  conferences:   { id: 'conferences',   label: 'Conferences',   icon: 'event' },
  regulation:    { id: 'regulation',    label: 'Regulation',    icon: 'gavel' },
  strategies:    { id: 'strategies',    label: 'Strategies',    icon: 'trending_up' },
  'market-data': { id: 'market-data',   label: 'Market Data',   icon: 'candlestick_chart' },
  jobs:          { id: 'jobs',          label: 'Jobs',          icon: 'work' },
}

export const AREAS: Area[] = [
  {
    id: 'ai',
    label: 'AI',
    icon: 'psychology',
    description: 'Foundation models, LLMs, Agents, and AI research',
    tabs: ['feed', 'people', 'organizations', 'papers', 'github', 'news', 'blog', 'videos', 'podcasts', 'datasets', 'tools', 'conferences', 'jobs'],
  },
  {
    id: 'quant',
    label: 'Quant',
    icon: 'functions',
    description: 'Quant research, algorithmic trading, and systematic strategies',
    tabs: ['feed', 'people', 'organizations', 'papers', 'github', 'news', 'blog', 'strategies', 'datasets', 'tools', 'conferences', 'jobs'],
  },
  {
    id: 'finance',
    label: 'Finance',
    icon: 'account_balance',
    description: 'Banks, asset managers, hedge funds, FinTech, and financial AI adoption',
    tabs: ['feed', 'organizations', 'people', 'news', 'blog', 'papers', 'regulation', 'videos', 'jobs'],
  },
  {
    id: 'market',
    label: 'Market',
    icon: 'show_chart',
    description: 'Macro, rates, FX, crypto, ETFs, and alternative data',
    tabs: ['feed', 'news', 'market-data', 'datasets', 'tools', 'regulation'],
  },
  {
    id: 'research',
    label: 'Research',
    icon: 'science',
    description: 'Academic papers from arXiv, SSRN, NeurIPS, ICML, and more',
    tabs: ['feed', 'papers', 'people', 'blog', 'conferences', 'datasets', 'tools', 'videos'],
  },
  {
    id: 'community',
    label: 'Community',
    icon: 'forum',
    description: 'Reddit, Hacker News, Stack Overflow, Discord, and YouTube',
    tabs: ['feed', 'news', 'blog', 'tools', 'videos', 'podcasts', 'jobs'],
  },
]

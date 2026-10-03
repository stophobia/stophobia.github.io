/**
 * Hugging Face API Service
 * Fetches trending models, datasets, and spaces from Hugging Face Hub
 */
import type { FeedEvent } from '@/types'

const HF_API = 'https://huggingface.co/api'

export interface HfModel {
  _id: string
  id: string // e.g. "meta-llama/Llama-3.1-8B"
  modelId: string
  author?: string
  sha?: string
  lastModified: string
  private: boolean
  gated: boolean | string
  disabled: boolean
  library_name?: string
  tags: string[]
  pipeline_tag?: string
  downloads: number
  likes: number
  createdAt: string
}

export interface HfDataset {
  _id: string
  id: string
  author?: string
  lastModified: string
  private: boolean
  tags: string[]
  downloads: number
  likes: number
  createdAt: string
  description?: string
}

export interface HfSpace {
  _id: string
  id: string
  author?: string
  lastModified: string
  private: boolean
  tags: string[]
  likes: number
  createdAt: string
  sdk?: string
  runtime?: { stage: string }
}

async function hfFetch<T>(path: string): Promise<T | null> {
  try {
    const resp = await fetch(`${HF_API}${path}`)
    if (!resp.ok) return null
    return (await resp.json()) as T
  } catch {
    return null
  }
}

function formatNumber(n: number): string {
  if (n >= 1_000_000) return `${(n / 1_000_000).toFixed(1)}M`
  if (n >= 1_000) return `${(n / 1_000).toFixed(1)}k`
  return String(n)
}

// ── Trending Models ─────────────────────────────────────
export async function fetchTrendingModels(limit = 20): Promise<FeedEvent[]> {
  const models = await hfFetch<HfModel[]>(
    `/models?sort=trendingScore&limit=${limit}&full=false`,
  )
  if (!models) return []

  return models.map((m): FeedEvent => ({
    id: `hf-model-${m._id}`,
    title: m.id,
    summary: [
      m.pipeline_tag ? `Pipeline: ${m.pipeline_tag}` : '',
      m.library_name ? `Library: ${m.library_name}` : '',
      `Downloads: ${formatNumber(m.downloads)}`,
      `Likes: ${formatNumber(m.likes)}`,
    ].filter(Boolean).join(' · '),
    url: `https://huggingface.co/${m.id}`,
    author: m.author || m.id.split('/')[0],
    organization: m.author || m.id.split('/')[0],
    organizationLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    category: 'tool',
    area: ['ai', 'research'],
    tags: [
      'HuggingFace',
      'model',
      ...(m.pipeline_tag ? [m.pipeline_tag] : []),
      ...(m.library_name ? [m.library_name] : []),
      ...(m.tags || []).filter((t) => !t.startsWith('license:') && !t.startsWith('arxiv:')).slice(0, 3),
    ],
    publishedAt: m.lastModified || m.createdAt,
    source: 'Hugging Face Models',
    sourceLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    score: m.likes,
    stars: m.likes,
    forks: m.downloads,
  }))
}

// ── Trending Datasets ───────────────────────────────────
export async function fetchTrendingDatasets(limit = 15): Promise<FeedEvent[]> {
  const datasets = await hfFetch<HfDataset[]>(
    `/datasets?sort=trendingScore&limit=${limit}&full=false`,
  )
  if (!datasets) return []

  return datasets.map((d): FeedEvent => ({
    id: `hf-dataset-${d._id}`,
    title: d.id,
    summary: [
      `Downloads: ${formatNumber(d.downloads)}`,
      `Likes: ${formatNumber(d.likes)}`,
    ].join(' · '),
    url: `https://huggingface.co/datasets/${d.id}`,
    author: d.author || d.id.split('/')[0],
    organization: d.author || d.id.split('/')[0],
    organizationLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    category: 'dataset',
    area: ['ai', 'research'],
    tags: [
      'HuggingFace',
      'dataset',
      ...(d.tags || []).filter((t) => !t.startsWith('license:')).slice(0, 4),
    ],
    publishedAt: d.lastModified || d.createdAt,
    source: 'Hugging Face Datasets',
    sourceLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    score: d.likes,
    stars: d.likes,
    forks: d.downloads,
  }))
}

// ── Trending Spaces ─────────────────────────────────────
export async function fetchTrendingSpaces(limit = 15): Promise<FeedEvent[]> {
  const spaces = await hfFetch<HfSpace[]>(
    `/spaces?sort=trendingScore&limit=${limit}&full=false`,
  )
  if (!spaces) return []

  return spaces.map((s): FeedEvent => ({
    id: `hf-space-${s._id}`,
    title: s.id,
    summary: [
      s.sdk ? `SDK: ${s.sdk}` : '',
      `Likes: ${formatNumber(s.likes)}`,
    ].filter(Boolean).join(' · '),
    url: `https://huggingface.co/spaces/${s.id}`,
    author: s.author || s.id.split('/')[0],
    organization: s.author || s.id.split('/')[0],
    organizationLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    category: 'tool',
    area: ['ai', 'community'],
    tags: [
      'HuggingFace',
      'space',
      ...(s.sdk ? [s.sdk] : []),
      ...(s.tags || []).filter((t) => !t.startsWith('license:')).slice(0, 3),
    ],
    publishedAt: s.lastModified || s.createdAt,
    source: 'Hugging Face Spaces',
    sourceLogo: 'https://huggingface.co/front/assets/huggingface_logo-noborder.svg',
    score: s.likes,
    stars: s.likes,
  }))
}

// ── Combined fetch ──────────────────────────────────────
export async function fetchAllHuggingFace(): Promise<FeedEvent[]> {
  const [models, datasets, spaces] = await Promise.allSettled([
    fetchTrendingModels(),
    fetchTrendingDatasets(),
    fetchTrendingSpaces(),
  ])

  const events: FeedEvent[] = []
  if (models.status === 'fulfilled') events.push(...models.value)
  if (datasets.status === 'fulfilled') events.push(...datasets.value)
  if (spaces.status === 'fulfilled') events.push(...spaces.value)

  return events.sort(
    (a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime(),
  )
}

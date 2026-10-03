/**
 * GitHub API Service
 * Fetches trending repositories and recent releases from GitHub
 */
import type { AreaTag, FeedEvent } from '@/types'

const GITHUB_API = 'https://api.github.com'

export interface GitHubRepo {
  id: number
  full_name: string
  name: string
  description: string | null
  html_url: string
  stargazers_count: number
  forks_count: number
  language: string | null
  pushed_at: string
  created_at: string
  owner: { login: string; avatar_url: string }
  topics: string[]
  fork: boolean
}

export interface GitHubRelease {
  id: number
  tag_name: string
  name: string | null
  body: string | null
  html_url: string
  published_at: string
  author: { login: string; avatar_url: string }
}

const AI_QUANT_REPOS = [
  'langchain-ai/langchain',
  'langchain-ai/langgraph',
  'run-llama/llama_index',
  'vllm-project/vllm',
  'openai/openai-python',
  'huggingface/transformers',
  'pytorch/pytorch',
  'ray-project/ray',
  'mlflow/mlflow',
  'microsoft/autogen',
  'OpenHands/OpenHands',
  'continuedev/continue',
  'AI4Finance-Foundation/FinRL',
  'microsoft/qlib',
  'deepseek-ai/DeepSeek-V3',
  'google/gemma_pytorch',
  'ml-explore/mlx',
  'feast-dev/feast',
]

const QUANT_REPOS = new Set(['AI4Finance-Foundation/FinRL', 'microsoft/qlib'])

// scripts/collect.ts adds Authorization when GITHUB_TOKEN is set
export const HEADERS: Record<string, string> = {
  Accept: 'application/vnd.github.v3+json',
}

async function ghFetch<T>(path: string): Promise<T | null> {
  try {
    const resp = await fetch(`${GITHUB_API}${path}`, { headers: HEADERS })
    if (!resp.ok) return null
    return await resp.json() as T
  } catch {
    return null
  }
}

export async function fetchGitHubReleases(): Promise<FeedEvent[]> {
  const events: FeedEvent[] = []
  const results = await Promise.allSettled(
    AI_QUANT_REPOS.map(async (repo) => {
      const releases = await ghFetch<GitHubRelease[]>(`/repos/${repo}/releases?per_page=3`)
      if (!releases) return []
      return releases.map((r): FeedEvent => ({
        id: `gh-release-${r.id}`,
        title: `${repo.split('/')[1]} ${r.tag_name}: ${r.name || r.tag_name}`,
        summary: (r.body || '').slice(0, 280) || `New release ${r.tag_name} for ${repo}`,
        url: r.html_url,
        author: r.author?.login,
        authorAvatar: r.author?.avatar_url,
        organization: repo.split('/')[0],
        category: 'github_release',
        area: QUANT_REPOS.has(repo) ? ['ai', 'quant'] : ['ai'],
        tags: ['GitHub', 'release', repo.split('/')[1]],
        publishedAt: r.published_at,
        source: 'GitHub',
        sourceLogo: 'https://github.githubassets.com/favicons/favicon.svg',
      }))
    }),
  )
  for (const r of results) {
    if (r.status === 'fulfilled') events.push(...r.value)
  }
  return events.sort((a, b) => new Date(b.publishedAt).getTime() - new Date(a.publishedAt).getTime())
}

export async function fetchTrendingRepos(): Promise<FeedEvent[]> {
  // GitHub has no trending API: most-starred AI/quant repos created in the last 30 days
  const since = new Date(Date.now() - 30 * 86400000).toISOString().slice(0, 10)
  const q = `created:>${since} stars:>100 llm OR agent OR quant in:name,description,topics`
  const data = await ghFetch<{ items: GitHubRepo[] }>(
    `/search/repositories?q=${encodeURIComponent(q)}&sort=stars&order=desc&per_page=20`,
  )
  if (!data?.items) return []
  return data.items.map((repo): FeedEvent => ({
    id: `gh-repo-${repo.id}`,
    title: repo.full_name,
    summary: repo.description || 'No description',
    url: repo.html_url,
    author: repo.owner?.login,
    authorAvatar: repo.owner?.avatar_url,
    organization: repo.owner?.login,
    category: 'github_repo',
    area: ['ai'],
    tags: ['GitHub', 'trending', ...(repo.topics || []).slice(0, 5)],
    publishedAt: repo.pushed_at,
    source: 'GitHub Trending',
    sourceLogo: 'https://github.githubassets.com/favicons/favicon.svg',
    stars: repo.stargazers_count,
    forks: repo.forks_count,
  }))
}

// A person's newest public repositories, for their timeline
export async function fetchUserRepos(login: string, area: AreaTag[]): Promise<FeedEvent[]> {
  const repos = await ghFetch<GitHubRepo[]>(`/users/${login}/repos?sort=created&per_page=5`)
  if (!repos) return []
  return repos.filter((r) => !r.fork).map((repo): FeedEvent => ({
    id: `gh-repo-${repo.id}`,
    title: `New repository: ${repo.full_name}`,
    summary: repo.description || 'No description',
    url: repo.html_url,
    author: repo.owner.login,
    authorAvatar: repo.owner.avatar_url,
    organization: repo.owner.login,
    category: 'github_repo',
    area,
    tags: ['GitHub', ...(repo.topics || []).slice(0, 4)],
    publishedAt: repo.created_at,
    source: 'GitHub',
    sourceLogo: 'https://github.githubassets.com/favicons/favicon.svg',
    stars: repo.stargazers_count,
    forks: repo.forks_count,
  }))
}

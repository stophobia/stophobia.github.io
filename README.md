# FAIH — Financial AI Intelligence Hub

Static Vue 3 + Vite site served from GitHub Pages at https://stophobia.github.io.

Feeds are collected at build time, not in the browser: `scripts/collect.ts` fetches every source
(RSS/Atom, GitHub API, Hugging Face) and writes `public/data/feed.json`, which the app loads.
The deploy workflow runs it every 30 minutes.

```sh
npm ci
npm run collect   # writes public/data/feed.json (set GITHUB_TOKEN to avoid GitHub rate limits)
npm run dev
```

Where sources are defined:

- `src/data/feeds.ts` — RSS/Atom/arXiv feeds (`orgId` links a feed to an organization page)
- `src/data/people.ts` — people; `blogFeed`, `arxivAuthor` and `links.github` feed each person's timeline
- `src/services/githubService.ts` — tracked repositories for release events

The collected `data/feed.json` is public, so other tools and agents can read the same events.

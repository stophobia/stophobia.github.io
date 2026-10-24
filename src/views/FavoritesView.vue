<template>
  <div class="favorites-view">
    <header class="fav-header">
      <h1 class="page-title">Favorites</h1>
      <span v-if="favorites.length" class="badge">{{ favorites.length }}</span>
      <div v-if="favorites.length" class="fav-actions">
        <button class="btn btn-ghost" @click="picker?.click()">
          <span class="material-symbols-outlined" aria-hidden="true">upload_file</span> Re-import
        </button>
        <button class="btn btn-ghost" @click="clear">
          <span class="material-symbols-outlined" aria-hidden="true">delete</span> Clear
        </button>
      </div>
      <input ref="picker" type="file" accept=".html,.htm,text/html" hidden @change="onFile" />
    </header>

    <p v-if="error" class="notice">{{ error }}</p>

    <template v-if="favorites.length">
      <input
        v-model="query"
        type="search"
        class="input fav-search"
        placeholder="Search title, URL or folder…"
        aria-label="Search favorites"
        autocomplete="off"
        @keydown.escape="query = ''"
      />
      <AppScroller class="cat-scroller">
        <nav class="fav-cats" aria-label="Categories">
          <button class="chip" :class="{ active: !category }" @click="category = ''">
            All <span class="cat-count">{{ favorites.length }}</span>
          </button>
          <button
            v-for="[name, count] in categories"
            :key="name"
            class="chip"
            :class="{ active: category === name }"
            @click="category = category === name ? '' : name"
          >
            {{ name }} <span class="cat-count">{{ count }}</span>
          </button>
        </nav>
      </AppScroller>

      <p v-if="query.trim()" class="muted">{{ visible.length }} of {{ favorites.length }} match “{{ query.trim() }}”</p>

      <div v-if="groups.length" class="fav-groups">
        <section v-for="g in groups" :key="g.key" class="fav-group card">
          <h2 class="group-title">
            <span class="group-name">
              <span v-for="(seg, i) in g.path.slice(0, -1)" :key="i" class="group-parent">{{ seg }} / </span>{{ g.path.at(-1) ?? UNSORTED }}
            </span>
            <span class="badge">{{ g.items.length }}</span>
          </h2>
          <ul class="fav-list">
            <li v-for="f in g.items" :key="f.url">
              <a :href="f.url" :title="f.url" target="_blank" rel="noopener" class="fav-link">
                <span class="fav-title">{{ f.title }}</span>
                <span class="fav-host">{{ host(f.url) }}</span>
              </a>
            </li>
          </ul>
        </section>
      </div>
      <p v-else class="empty card">No favorites match this search.</p>
    </template>

    <label v-else class="empty card upload">
      <span class="material-symbols-outlined" aria-hidden="true">upload_file</span>
      Import bookmarks exported from Chrome or Firefox (.html)
      <input type="file" accept=".html,.htm,text/html" @change="onFile" />
    </label>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import AppScroller from '@/components/layout/AppScroller.vue'

// path: folder names from the outermost in; [] = not in any folder
interface Favorite { title: string; url: string; path: string[] }

const KEY = 'favorites'
const UNSORTED = 'Unsorted'
const favorites = ref<Favorite[]>(load())
const error = ref('')
const query = ref('')
const category = ref('')
const picker = ref<HTMLInputElement>()

function load(): Favorite[] {
  try {
    // entries saved before folders were kept have no path
    return JSON.parse(localStorage.getItem(KEY) || '[]').map((f: Favorite) => ({ ...f, path: f.path ?? [] }))
  } catch {
    return []
  }
}

const byName = (a: string, b: string) => a.localeCompare(b, undefined, { numeric: true, sensitivity: 'base' })
const topOf = (f: Favorite) => f.path[0] ?? UNSORTED
const host = (url: string) => url.replace(/^https?:\/\/(www\.)?/i, '').split(/[/?#]/)[0]

const categories = computed(() => {
  const counts = new Map<string, number>()
  for (const f of favorites.value) counts.set(topOf(f), (counts.get(topOf(f)) ?? 0) + 1)
  return [...counts].sort(([a], [b]) => (a === UNSORTED ? 1 : b === UNSORTED ? -1 : byName(a, b)))
})

const visible = computed(() => {
  const q = query.value.trim().toLowerCase()
  return favorites.value.filter(
    (f) =>
      (!category.value || topOf(f) === category.value) &&
      (!q || [f.title, f.url, ...f.path].some((s) => s.toLowerCase().includes(q))),
  )
})

// One section per folder; a subfolder sorts right after its parent, Unsorted goes last
const groups = computed(() => {
  const map = new Map<string, { key: string; path: string[]; items: Favorite[] }>()
  for (const f of visible.value) {
    const key = f.path.join(' / ')
    if (!map.has(key)) map.set(key, { key, path: f.path, items: [] })
    map.get(key)!.items.push(f)
  }
  for (const g of map.values()) g.items.sort((a, b) => byName(a.title, b.title))
  return [...map.values()].sort((a, b) => (!a.key ? 1 : !b.key ? -1 : byName(a.key, b.key)))
})

// Chrome and Firefox both export the Netscape bookmark format:
// <DT><H3>Folder</H3><DL><p><DT><A HREF="...">title</A> ... </DL>
function folderPath(a: Element): string[] {
  const folders: Element[] = []
  for (let dl = a.closest('dl'); dl; dl = dl.parentElement?.closest('dl') ?? null) {
    const h3 = dl.parentElement?.querySelector(':scope > h3')
    if (h3) folders.unshift(h3)
  }
  // The toolbar and "Other Bookmarks" roots wrap everything; drop them unless nothing else is left
  const named = folders.filter((h) => !h.hasAttribute('personal_toolbar_folder') && !h.hasAttribute('unfiled_bookmarks_folder'))
  return (named.length ? named : folders).map((h) => h.textContent?.trim() || UNSORTED)
}

async function onFile(e: Event) {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0]
  input.value = '' // lets the same file be picked again
  if (!file) return
  const doc = new DOMParser().parseFromString(await file.text(), 'text/html')
  const links = [...doc.querySelectorAll('a[href]')]
    .map((a) => {
      const url = a.getAttribute('href')!
      return { title: a.textContent?.trim() || url, url, path: folderPath(a) }
    })
    .filter((f) => /^https?:\/\//i.test(f.url)) // drops javascript:, place: and the like
  if (!links.length) {
    error.value = 'No bookmarks found in this file.'
    return
  }
  const seen = new Set<string>()
  const unique = links.filter((f) => !seen.has(f.url) && seen.add(f.url))
  try {
    localStorage.setItem(KEY, JSON.stringify(unique))
  } catch {
    error.value = 'Could not save bookmarks in this browser.'
    return
  }
  error.value = ''
  query.value = ''
  category.value = ''
  favorites.value = unique
}

function clear() {
  localStorage.removeItem(KEY)
  favorites.value = []
  query.value = ''
  category.value = ''
}
</script>

<style scoped>
.favorites-view { display: flex; flex-direction: column; gap: var(--space-md); }
.fav-header { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-xs) var(--space-sm); }
.fav-actions { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-xs); margin-left: auto; }
.fav-actions .btn { font-size: var(--text-sm); }
.fav-search { width: 100%; font-size: var(--text-sm); }
.fav-search:focus { outline: 2px solid var(--accent); outline-offset: 2px; }
.upload { cursor: pointer; }

.cat-scroller { padding-bottom: var(--space-sm); border-bottom: 1px solid var(--border); }
.fav-cats { display: flex; gap: var(--space-2xs); }
.cat-count { font-size: var(--text-xs); opacity: 0.7; }

/* Category cards flow into as many columns as fit */
.fav-groups { columns: 20rem; column-gap: var(--space-sm); }
.fav-group { break-inside: avoid; margin-bottom: var(--space-sm); padding: var(--space-xs) 0; }
.group-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--space-xs);
  padding: var(--space-2xs) var(--space-md) var(--space-xs);
  border-bottom: 1px solid var(--border);
  font-size: var(--text-md);
}
.group-name { min-width: 0; overflow-wrap: anywhere; }
.group-parent { color: var(--ink-muted); font-weight: var(--weight-medium); }

.fav-list { list-style: none; margin: 0; padding: var(--space-2xs) 0 0; }
.fav-link {
  display: flex;
  align-items: baseline;
  gap: var(--space-xs);
  padding: var(--space-2xs) var(--space-md);
}
.fav-link:hover { background: var(--surface-sunken); }
.fav-link:hover .fav-title { color: var(--accent); }
.fav-title { flex: 1; font-size: var(--text-sm); min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.fav-host { flex-shrink: 0; max-width: 45%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--ink-muted); font-size: var(--text-xs); }
</style>

<template>
  <div class="favorites-view">
    <header class="fav-header">
      <h1 class="page-title">Favorites</h1>
      <span v-if="favorites.length" class="badge">{{ favorites.length }}</span>
      <div v-if="favorites.length" class="fav-actions">
        <button class="btn btn-ghost" @click="picker?.click()">
          <span class="material-symbols-outlined" aria-hidden="true">upload_file</span> Re-import
        </button>
        <button class="btn btn-ghost" :disabled="!!scan" @click="sanitize">
          <span class="material-symbols-outlined" aria-hidden="true">link_off</span>
          {{ scan ? `Checking ${scan.done}/${scan.total}` : 'Sanitize' }}
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
            <li v-for="f in g.items" :key="f.url" class="fav-item">
              <a :href="f.url" :title="f.url" target="_blank" rel="noopener" class="fav-link">
                <span class="fav-title">{{ f.title }}</span>
                <span class="fav-host">{{ host(f.url) }}</span>
              </a>
              <span class="fav-tools">
                <button class="btn-icon" title="Edit" :aria-label="`Edit ${f.title}`" @click="openEdit(f)">
                  <span class="material-symbols-outlined" aria-hidden="true">edit</span>
                </button>
                <button class="btn-icon fav-delete" title="Delete" :aria-label="`Delete ${f.title}`" @click="openDelete(f)">
                  <span class="material-symbols-outlined" aria-hidden="true">delete</span>
                </button>
              </span>
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

    <dialog ref="editDialog" class="dialog card" aria-labelledby="edit-title" closedby="any">
      <form class="dialog-form" @submit.prevent="saveEdit">
        <h2 id="edit-title" class="dialog-title">Edit favorite</h2>
        <label class="field">Title <input v-model="draft.title" class="input" required /></label>
        <label class="field">URL <input v-model="draft.url" class="input" type="url" pattern="https?://.+" required /></label>
        <p v-if="urlTaken" class="notice">Another favorite already has this URL.</p>
        <label class="field">
          Folder
          <select v-model="draft.path" class="input">
            <option v-for="[name, path] in folders" :key="name" :value="path">{{ name }}</option>
            <option :value="[]">{{ UNSORTED }}</option>
          </select>
        </label>
        <div class="dialog-actions">
          <button type="button" class="btn btn-ghost" @click="editDialog?.close()">
            <span class="material-symbols-outlined" aria-hidden="true">close</span> Cancel
          </button>
          <button class="btn btn-primary">
            <span class="material-symbols-outlined" aria-hidden="true">check</span> Save
          </button>
        </div>
      </form>
    </dialog>

    <dialog ref="deleteDialog" class="dialog card" aria-labelledby="delete-title" closedby="any">
      <form class="dialog-form" @submit.prevent="remove">
        <h2 id="delete-title" class="dialog-title">Delete favorite?</h2>
        <p class="muted">“{{ target?.title }}” will be removed from Favorites.</p>
        <div class="dialog-actions">
          <button type="button" class="btn btn-ghost" @click="deleteDialog?.close()">
            <span class="material-symbols-outlined" aria-hidden="true">close</span> Cancel
          </button>
          <button class="btn btn-danger">
            <span class="material-symbols-outlined" aria-hidden="true">delete</span> Delete
          </button>
        </div>
      </form>
    </dialog>

    <dialog ref="sanitizeDialog" class="dialog card" aria-labelledby="sanitize-title" closedby="any">
      <form class="dialog-form" @submit.prevent="removeDead">
        <h2 id="sanitize-title" class="dialog-title">
          {{ dead.length ? `${dead.length} sites did not respond` : 'Every site responded' }}
        </h2>
        <template v-if="dead.length">
          <p class="muted">Checked from this browser, so a site behind a VPN or blocked by an extension shows up here too. Untick any to keep.</p>
          <ul class="dead-list">
            <li v-for="f in dead" :key="f.url">
              <label class="dead-item" :title="f.url">
                <input v-model="doomed" type="checkbox" :value="f.url" />
                <span class="fav-title">{{ f.title }}</span>
                <span class="fav-host">{{ host(f.url) }}</span>
              </label>
            </li>
          </ul>
        </template>
        <p v-if="skipped" class="muted">{{ skipped }} http:// links can't be checked from an https page and were kept.</p>
        <div class="dialog-actions">
          <button type="button" class="btn btn-ghost" @click="sanitizeDialog?.close()">
            <span class="material-symbols-outlined" aria-hidden="true">close</span> {{ dead.length ? 'Cancel' : 'Close' }}
          </button>
          <button v-if="dead.length" class="btn btn-danger" :disabled="!doomed.length">
            <span class="material-symbols-outlined" aria-hidden="true">delete</span> Delete {{ doomed.length }}
          </button>
        </div>
      </form>
    </dialog>
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
const editDialog = ref<HTMLDialogElement>()
const deleteDialog = ref<HTMLDialogElement>()
const target = ref<Favorite>()
const draft = ref({ title: '', url: '', path: [] as string[] })

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
  if (!persist(unique)) return
  query.value = ''
  category.value = ''
}

// Saves and shows the list; false when the browser refuses to store it
function persist(list: Favorite[]): boolean {
  try {
    localStorage.setItem(KEY, JSON.stringify(list))
  } catch {
    error.value = 'Could not save bookmarks in this browser.'
    return false
  }
  error.value = ''
  favorites.value = list
  return true
}

// Every folder in use as [label, path], labelled like the group headings, for the edit dialog's picker
const folders = computed(() => {
  const map = new Map(favorites.value.map((f) => [f.path.join(' / '), f.path]))
  map.delete('') // Unsorted has its own fixed option
  return [...map].sort(([a], [b]) => byName(a, b))
})
const urlTaken = computed(() => favorites.value.some((f) => f !== target.value && f.url === draft.value.url.trim()))

function openEdit(f: Favorite) {
  target.value = f
  draft.value = { title: f.title, url: f.url, path: f.path }
  editDialog.value?.showModal()
}

function saveEdit() {
  if (urlTaken.value) return
  const url = draft.value.url.trim()
  const edited = {
    title: draft.value.title.trim() || url,
    url,
    path: draft.value.path,
  }
  persist(favorites.value.map((f) => (f === target.value ? edited : f)))
  editDialog.value?.close()
}

function openDelete(f: Favorite) {
  target.value = f
  deleteDialog.value?.showModal()
}

function remove() {
  persist(favorites.value.filter((f) => f !== target.value))
  deleteDialog.value?.close()
}

const sanitizeDialog = ref<HTMLDialogElement>()
const scan = ref<{ done: number; total: number }>()
const dead = ref<Favorite[]>([])
const doomed = ref<string[]>([]) // URLs ticked for removal
const skipped = ref(0)

// Cross-origin responses are hidden, but an opaque no-cors request still settles once the server answers;
// it rejects only on DNS, connection, TLS or timeout failure. So a 404 page counts as reachable.
async function reachable(url: string) {
  try {
    await fetch(url, { method: 'HEAD', mode: 'no-cors', signal: AbortSignal.timeout(10_000) })
    return true
  } catch {
    return false
  }
}

async function sanitize() {
  if (!navigator.onLine) {
    error.value = 'You are offline, so every site would look unreachable.'
    return
  }
  // An https page may not fetch http:// URLs (mixed content), so those can't be tested
  const list = favorites.value.filter((f) => /^https:/i.test(f.url))
  skipped.value = favorites.value.length - list.length
  scan.value = { done: 0, total: list.length }
  const found: Favorite[] = []
  let next = 0
  // ponytail: 8 probes at a time; raise it if big lists feel slow
  await Promise.all(
    Array.from({ length: 8 }, async () => {
      while (next < list.length) {
        const f = list[next++]
        if (!(await reachable(f.url))) found.push(f)
        scan.value!.done++
      }
    }),
  )
  scan.value = undefined
  dead.value = found.sort((a, b) => byName(a.title, b.title))
  doomed.value = found.map((f) => f.url)
  sanitizeDialog.value?.showModal()
}

function removeDead() {
  const drop = new Set(doomed.value)
  persist(favorites.value.filter((f) => !drop.has(f.url)))
  sanitizeDialog.value?.close()
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
.fav-item { display: flex; align-items: center; padding-right: var(--space-xs); }
.fav-item:hover { background: var(--surface-sunken); }
.fav-link {
  display: flex;
  flex: 1;
  min-width: 0;
  align-items: baseline;
  gap: var(--space-xs);
  padding: var(--space-2xs) var(--space-xs) var(--space-2xs) var(--space-md);
}
.fav-link:hover .fav-title { color: var(--accent); }
.fav-tools { display: flex; font-size: var(--text-sm); }
.fav-tools .btn-icon:hover { background: var(--border); }
.fav-tools .fav-delete:hover { color: var(--tone-critical); }
/* With a mouse the tools take no room until hover or focus; on touch screens they always show */
@media (hover: hover) {
  .fav-item:not(:hover, :focus-within) .fav-tools { display: none; }
}
.fav-title { flex: 1; font-size: var(--text-sm); min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.fav-host { flex-shrink: 0; max-width: 45%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--ink-muted); font-size: var(--text-xs); }

/* The global reset zeroes margins, so the modal is re-centred here */
.dialog { margin: auto; width: min(28rem, 100% - 2 * var(--space-md)); padding: var(--space-lg); color: var(--ink); }
.dialog::backdrop { background: var(--backdrop); }
.dialog-form { display: flex; flex-direction: column; gap: var(--space-sm); }
.dialog-title { font-size: var(--text-lg); }
.field { display: flex; flex-direction: column; gap: var(--space-2xs); font-size: var(--text-sm); color: var(--ink-muted); }
.field .input { color: var(--ink); }
.dialog-actions { display: flex; justify-content: flex-end; gap: var(--space-xs); margin-top: var(--space-xs); }
.btn-danger { background: var(--tone-critical); color: var(--ink-inverted); }
.btn-danger:hover { filter: brightness(0.9); }

.dead-list { list-style: none; margin: 0; padding: 0; max-height: 50vh; overflow-y: auto; }
.dead-item { display: flex; align-items: baseline; gap: var(--space-xs); padding: var(--space-2xs) 0; color: var(--ink); cursor: pointer; }
</style>

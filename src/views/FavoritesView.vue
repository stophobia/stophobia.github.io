<template>
  <div class="favorites-view">
    <header class="fav-header">
      <h1 class="page-title">Favorites</h1>
      <button v-if="favorites.length" class="btn btn-ghost" @click="clear">
        <span class="material-symbols-outlined" aria-hidden="true">delete</span> Clear
      </button>
    </header>

    <div v-if="favorites.length" class="card-grid">
      <a v-for="f in favorites" :key="f.url" :href="f.url" target="_blank" rel="noopener" class="fav-card card">
        <div class="fav-title">{{ f.title }}</div>
        <div class="muted fav-url">{{ f.url }}</div>
      </a>
    </div>

    <label v-else class="empty card upload">
      <span class="material-symbols-outlined" aria-hidden="true">upload_file</span>
      Import bookmarks exported from Chrome or Firefox (.html)
      <input type="file" accept=".html,.htm,text/html" @change="onFile" />
      <p v-if="error" class="notice">{{ error }}</p>
    </label>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Favorite { title: string; url: string }

const KEY = 'favorites'
const favorites = ref<Favorite[]>(load())
const error = ref('')

function load(): Favorite[] {
  try {
    return JSON.parse(localStorage.getItem(KEY) || '[]')
  } catch {
    return []
  }
}

// Chrome and Firefox both export the Netscape bookmark format: <DT><A HREF="...">title</A>
async function onFile(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (!file) return
  const doc = new DOMParser().parseFromString(await file.text(), 'text/html')
  const links = [...doc.querySelectorAll('a[href]')]
    .map((a) => {
      const url = a.getAttribute('href')!
      return { title: a.textContent?.trim() || url, url }
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
  favorites.value = unique
}

function clear() {
  localStorage.removeItem(KEY)
  favorites.value = []
}
</script>

<style scoped>
.favorites-view { display: flex; flex-direction: column; gap: var(--space-md); }
.fav-header { display: flex; align-items: center; justify-content: space-between; gap: var(--space-md); }
.upload { cursor: pointer; }
.fav-card { min-width: 0; padding: var(--space-sm) var(--space-md); }
.fav-title { font-weight: var(--weight-bold); }
.fav-url { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>

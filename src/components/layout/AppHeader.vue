<template>
  <header class="app-header glass-strong">
    <div class="header-inner">
      <!-- Logo -->
      <RouterLink to="/" class="logo">
        <div class="logo-icon">
          <span>F</span>
        </div>
        <div class="logo-text">
          <span class="logo-name text-gradient">FAIH</span>
          <span class="logo-tagline">Financial AI Intelligence Hub</span>
        </div>
      </RouterLink>

      <!-- Search bar -->
      <div class="search-wrap" :class="{ focused: searchFocused }">
        <span class="search-icon">⌕</span>
        <input
          id="global-search"
          v-model="searchQuery"
          type="text"
          placeholder="Search people, papers, orgs..."
          class="search-input"
          @focus="searchFocused = true"
          @blur="searchFocused = false"
          @keyup.enter="goSearch"
          @keydown.escape="clearSearch"
          autocomplete="off"
        />
      </div>

      <!-- Right actions -->
      <div class="header-actions">
        <!-- Live indicator -->
        <div class="live-badge" :class="{ refreshing: feedStore.isRefreshing }">
          <div class="pulse-dot"></div>
          <span>{{ feedStore.isRefreshing ? 'Updating…' : 'Live' }}</span>
        </div>
        <!-- Refresh -->
        <button class="btn-icon" @click="feedStore.fetchFeeds()" title="Refresh feeds" id="refresh-btn">
          <span :class="{ 'spin-icon': feedStore.isRefreshing }">↻</span>
        </button>
        <!-- GitHub link -->
        <a
          href="https://github.com/stophobia"
          target="_blank"
          rel="noopener"
          class="btn-icon"
          title="GitHub"
          id="github-header-link"
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.164 6.839 9.49.5.09.682-.218.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.907-.62.069-.607.069-.607 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.252-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0 1 12 6.836a9.59 9.59 0 0 1 2.504.337c1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.202 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.137 20.16 22 16.417 22 12c0-5.523-4.477-10-10-10z"/>
          </svg>
        </a>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useFeedStore } from '@/stores/feedStore'

const router = useRouter()
const feedStore = useFeedStore()
const searchQuery = ref('')
const searchFocused = ref(false)

function goSearch() {
  if (searchQuery.value.trim()) {
    router.push({ name: 'search', query: { q: searchQuery.value } })
  }
}

function clearSearch() {
  searchQuery.value = ''
  searchFocused.value = false
}
</script>

<style scoped>
.app-header {
  height: var(--header-height);
  position: sticky;
  top: 0;
  z-index: 100;
  border-bottom: 1px solid var(--border-subtle);
}

.header-inner {
  display: flex;
  align-items: center;
  gap: 16px;
  height: 100%;
  padding: 0 20px;
}

/* Logo */
.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  flex-shrink: 0;
}

.logo-icon {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 16px;
  color: white;
  flex-shrink: 0;
}

.logo-text {
  display: flex;
  flex-direction: column;
  line-height: 1.1;
}

.logo-name {
  font-size: 15px;
  font-weight: 800;
  letter-spacing: -0.02em;
}

.logo-tagline {
  font-size: 10px;
  color: var(--text-muted);
  font-weight: 400;
  letter-spacing: 0.01em;
  white-space: nowrap;
}

@media (max-width: 600px) {
  .logo-tagline { display: none; }
}

/* Search */
.search-wrap {
  flex: 1;
  min-width: 0; /* let the input shrink on phones instead of pushing the actions off-screen */
  max-width: 480px;
  display: flex;
  align-items: center;
  gap: 8px;
  background: var(--bg-elevated);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 0 12px;
  height: 36px;
  transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.search-wrap.focused {
  border-color: var(--accent-ai);
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
}

.search-icon {
  color: var(--text-muted);
  font-size: 18px;
  flex-shrink: 0;
}

.search-input {
  flex: 1;
  min-width: 0;
  background: none;
  border: none;
  outline: none;
  color: var(--text-primary);
  font-size: 13px;
  font-family: var(--font-sans);
}

.search-input::placeholder { color: var(--text-muted); }

/* Actions */
.header-actions {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
  margin-left: auto;
}

.live-badge {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 100px;
  background: rgba(16, 185, 129, 0.1);
  border: 1px solid rgba(16, 185, 129, 0.2);
  font-size: 12px;
  font-weight: 500;
  color: #34d399;
  transition: all var(--transition-base);
}

.live-badge.refreshing {
  background: rgba(99, 102, 241, 0.1);
  border-color: rgba(99, 102, 241, 0.3);
  color: #818cf8;
}

.live-badge span { white-space: nowrap; }

@media (max-width: 600px) {
  .live-badge span { display: none; }
}

.btn-icon {
  width: 34px;
  height: 34px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-secondary);
  font-size: 16px;
  transition: all var(--transition-fast);
}

.btn-icon:hover {
  background: var(--bg-hover);
  color: var(--text-primary);
}

.spin-icon {
  display: inline-block;
  animation: spin 0.7s linear infinite;
}
</style>

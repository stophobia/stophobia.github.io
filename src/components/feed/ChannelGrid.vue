<template>
  <div class="card-grid">
    <a v-for="ch in channels" :key="ch.url" :href="ch.url" target="_blank" rel="noopener" class="channel-card card">
      <div class="channel-text">
        <div class="channel-name">{{ ch.name }}</div>
        <div class="muted">{{ ch.desc }}</div>
      </div>
      <span class="badge">{{ ch.area }}</span>
      <span class="material-symbols-outlined channel-arrow" aria-hidden="true">open_in_new</span>
    </a>
  </div>
</template>

<script setup lang="ts">
import type { Channel } from '@/types'
defineProps<{ channels: Channel[] }>()
</script>

<style scoped>
.channel-card { display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm) var(--space-md); }
.channel-text { flex: 1; min-width: 0; }
.channel-name { font-weight: var(--weight-bold); }
.channel-arrow { color: var(--ink-muted); }
</style>

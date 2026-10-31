<template>
  <!-- Every tab's sub-menu: its own tabs and a search, the result count last; the filter groups below -->
  <div class="filter-bar card">
    <div class="filter-row">
      <slot name="tabs" />
      <input
        v-model="query"
        type="search"
        class="input"
        :placeholder="placeholder"
        :aria-label="placeholder"
        autocomplete="off"
        @keydown.escape="query = ''"
      />
      <span class="filter-count">{{ count }} results</span>
    </div>
    <div v-if="$slots.default" class="filter-row">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{ count: number; placeholder?: string }>(), { placeholder: 'Search…' })
const query = defineModel<string>({ default: '' })
</script>

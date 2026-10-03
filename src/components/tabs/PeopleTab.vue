<template>
  <div class="people-tab">
    <div class="tab-search">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search people..."
        class="tab-search-input"
        id="people-search"
      />
    </div>
    <div class="people-grid">
      <PersonCard
        v-for="person in filteredPeople"
        :key="person.id"
        :person="person"
      />
    </div>
    <div v-if="filteredPeople.length === 0" class="tab-empty">
      <span>👤</span>
      <p>No people found.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import PersonCard from '@/components/people/PersonCard.vue'
import { PEOPLE } from '@/data/people'
import type { AreaId } from '@/types'

const props = defineProps<{ areaId: AreaId }>()
const searchQuery = ref('')

const filteredPeople = computed(() => {
  let result = PEOPLE.filter((p) => p.areas.includes(props.areaId))
  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase()
    result = result.filter(
      (p) =>
        p.name.toLowerCase().includes(q) ||
        p.role.toLowerCase().includes(q) ||
        p.organization.toLowerCase().includes(q) ||
        p.tags.some((t) => t.toLowerCase().includes(q)),
    )
  }
  return result
})
</script>

<style scoped>
.people-tab { display: flex; flex-direction: column; gap: 16px; }

.tab-search { }

.tab-search-input {
  width: 100%;
  max-width: 360px;
  background: var(--bg-elevated);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 9px 14px;
  font-size: 13px;
  color: var(--text-primary);
  font-family: var(--font-sans);
  outline: none;
  transition: border-color var(--transition-fast);
}
.tab-search-input:focus { border-color: var(--accent-ai); }
.tab-search-input::placeholder { color: var(--text-muted); }

.people-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 14px;
}

.tab-empty {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 48px;
  color: var(--text-muted);
  font-size: 32px;
}
.tab-empty p { font-size: 14px; }
</style>

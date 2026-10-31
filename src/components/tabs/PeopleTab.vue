<template>
  <div class="people-tab">
    <FilterBar v-model="searchQuery" :count="filteredPeople.length" placeholder="Search people…" />
    <div class="card-grid">
      <PersonCard
        v-for="person in filteredPeople"
        :key="person.id"
        :person="person"
      />
    </div>
    <div v-if="filteredPeople.length === 0" class="empty">
      <span class="material-symbols-outlined empty-icon" aria-hidden="true">group</span>
      <p>No people found.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import FilterBar from '@/components/layout/FilterBar.vue'
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
.people-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.empty-icon { font-size: var(--text-xl); }
</style>

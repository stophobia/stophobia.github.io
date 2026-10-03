<template>
  <div class="orgs-tab">
    <div class="orgs-filter-bar">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search organizations..."
        class="input tab-search-input"
        id="orgs-search"
      />
      <div class="orgs-type-filters">
        <button
          v-for="type in orgTypes"
          :key="type.value"
          class="chip"
          :class="{ active: selectedType === type.value }"
          @click="selectedType = selectedType === type.value ? null : type.value"
        >
          {{ type.label }}
        </button>
      </div>
    </div>
    <div class="card-grid">
      <OrgCard
        v-for="org in filteredOrgs"
        :key="org.id"
        :org="org"
      />
    </div>
    <div v-if="filteredOrgs.length === 0" class="empty">
      <span class="material-symbols-outlined empty-icon" aria-hidden="true">corporate_fare</span>
      <p>No organizations found.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import OrgCard from '@/components/organizations/OrgCard.vue'
import { ORGANIZATIONS } from '@/data/organizations'
import type { AreaId } from '@/types'

const props = defineProps<{ areaId: AreaId }>()
const searchQuery = ref('')
const selectedType = ref<string | null>(null)

const orgTypes = [
  { value: 'ai_company', label: 'AI' },
  { value: 'hedge_fund', label: 'Hedge Fund' },
  { value: 'bank', label: 'Bank' },
  { value: 'asset_manager', label: 'Asset Mgr' },
  { value: 'research', label: 'Research' },
  { value: 'fintech', label: 'FinTech' },
  { value: 'regulator', label: 'Regulator' },
]

const filteredOrgs = computed(() => {
  let result = ORGANIZATIONS.filter((o) => o.areas.includes(props.areaId))
  if (selectedType.value) {
    result = result.filter((o) => o.type === selectedType.value)
  }
  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase()
    result = result.filter(
      (o) =>
        o.name.toLowerCase().includes(q) ||
        o.description.toLowerCase().includes(q) ||
        o.tags.some((t) => t.toLowerCase().includes(q)),
    )
  }
  return result
})
</script>

<style scoped>
.orgs-tab { display: flex; flex-direction: column; gap: var(--space-md); }
.orgs-filter-bar { display: flex; flex-direction: column; gap: var(--space-xs); }
.tab-search-input { width: 100%; max-width: 20rem; }
.orgs-type-filters { display: flex; gap: var(--space-2xs); flex-wrap: wrap; }
.empty-icon { font-size: var(--text-xl); }
</style>

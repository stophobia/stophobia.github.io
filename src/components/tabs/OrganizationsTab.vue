<template>
  <div class="orgs-tab">
    <div class="orgs-filter-bar">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search organizations..."
        class="tab-search-input"
        id="orgs-search"
      />
      <div class="orgs-type-filters">
        <button
          v-for="type in orgTypes"
          :key="type.value"
          class="filter-btn"
          :class="{ active: selectedType === type.value }"
          @click="selectedType = selectedType === type.value ? null : type.value"
        >
          {{ type.label }}
        </button>
      </div>
    </div>
    <div class="orgs-grid">
      <OrgCard
        v-for="org in filteredOrgs"
        :key="org.id"
        :org="org"
      />
    </div>
    <div v-if="filteredOrgs.length === 0" class="tab-empty">
      <span>🏢</span>
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
.orgs-tab { display: flex; flex-direction: column; gap: 16px; }

.orgs-filter-bar { display: flex; flex-direction: column; gap: 10px; }

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

.orgs-type-filters { display: flex; gap: 6px; flex-wrap: wrap; }

.filter-btn {
  padding: 5px 12px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 500;
  color: var(--text-muted);
  border: 1px solid var(--border-subtle);
  background: var(--bg-elevated);
  transition: all var(--transition-fast);
}
.filter-btn:hover { color: var(--text-primary); border-color: var(--border-default); }
.filter-btn.active { color: var(--text-primary); background: var(--accent-ai); border-color: var(--accent-ai); }

.orgs-grid {
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

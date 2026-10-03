<template>
  <nav class="mobile-nav glass-strong">
    <RouterLink
      v-for="area in areas"
      :key="area.id"
      :to="`/area/${area.id}/${area.tabs[0]}`"
      class="mobile-nav-item"
      :class="{ active: currentArea === area.id }"
      :style="currentArea === area.id ? { '--area-color': area.color } : {}"
    >
      <span class="mobile-nav-icon">{{ area.icon }}</span>
      <span class="mobile-nav-label">{{ area.label.split(' ')[0] }}</span>
    </RouterLink>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { AREAS } from '@/data/areas'

const route = useRoute()
const areas = AREAS
const currentArea = computed(() => route.params.areaId as string)
</script>

<style scoped>
.mobile-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: var(--mobile-nav-height);
  border-top: 1px solid var(--border-subtle);
  z-index: 100;
  justify-content: space-around;
  align-items: center;
  padding: 0 8px;
  padding-bottom: env(safe-area-inset-bottom, 0);
}

.mobile-nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  padding: 6px 4px; /* six items must fit a 360px phone */
  border-radius: var(--radius-md);
  color: var(--text-muted);
  transition: all var(--transition-fast);
  flex: 1;
  max-width: 72px;
}

.mobile-nav-item:hover,
.mobile-nav-item.active {
  color: var(--area-color, var(--accent-ai));
}

.mobile-nav-item.active {
  background: rgba(255, 255, 255, 0.04);
}

.mobile-nav-icon { font-size: 20px; }
.mobile-nav-label {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.01em;
}
</style>

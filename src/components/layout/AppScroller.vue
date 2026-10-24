<template>
  <div class="scroller">
    <button class="btn-icon arrow" aria-label="Scroll left" :disabled="!can.previous" @click="step(-1)">
      <span class="material-symbols-outlined" aria-hidden="true">chevron_left</span>
    </button>
    <div ref="viewport" class="viewport" @scroll.passive="measure">
      <slot />
    </div>
    <button class="btn-icon arrow" aria-label="Scroll right" :disabled="!can.next" @click="step(1)">
      <span class="material-symbols-outlined" aria-hidden="true">chevron_right</span>
    </button>
  </div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, reactive, ref } from 'vue'

/**
 * A row that can grow wider than its place, between two arrows (cross's
 * AppScroller). Each arrow is disabled while there is nothing more to see that
 * way; a press scrolls 60% of the visible width. The active item is scrolled
 * into view on mount. A wheel or trackpad still scrolls; the scrollbar is hidden.
 */
const viewport = ref<HTMLElement>()
const can = reactive({ previous: false, next: false })

function measure() {
  const element = viewport.value
  if (!element) return
  can.previous = element.scrollLeft > 1
  can.next = element.scrollLeft < element.scrollWidth - element.clientWidth - 1
}

function step(direction: 1 | -1) {
  const element = viewport.value
  element?.scrollBy({ left: direction * element.clientWidth * 0.6, behavior: 'smooth' })
}

// The row as well as the viewport: switching areas changes the row's width alone.
const observer = new ResizeObserver(measure)

onMounted(() => {
  const element = viewport.value
  if (!element) return
  observer.observe(element)
  for (const child of element.children) observer.observe(child)
  element
    .querySelector('[aria-current="page"], .active')
    ?.scrollIntoView({ block: 'nearest', inline: 'nearest' })
  measure()
})

onBeforeUnmount(() => observer.disconnect())
</script>

<style scoped>
.scroller {
  display: flex;
  align-items: center;
  gap: var(--space-2xs);
  min-width: 0;
}

.viewport {
  display: flex;
  flex: 1;
  min-width: 0;
  overflow-x: auto;
  overscroll-behavior-x: contain;
  scrollbar-width: none;
}

.viewport > :slotted(*) { flex: none; }

/* Faded in place, not a grey button */
.arrow:disabled {
  background: none;
  color: var(--ink-muted);
  opacity: 0.4;
  cursor: default;
}
</style>

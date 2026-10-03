<template>
  <div id="faih-app">
    <AppHeader />
    <div class="app-layout">
      <SideNav class="side-nav-desktop" />
      <main class="main-content" id="main-content">
        <RouterView v-slot="{ Component }">
          <Transition name="page" mode="out-in">
            <component :is="Component" />
          </Transition>
        </RouterView>
      </main>
    </div>
    <MobileNav class="mobile-nav" />
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import AppHeader from '@/components/layout/AppHeader.vue'
import SideNav from '@/components/layout/SideNav.vue'
import MobileNav from '@/components/layout/MobileNav.vue'
import { useFeedStore } from '@/stores/feedStore'

const feedStore = useFeedStore()
onMounted(() => feedStore.fetchFeeds())
</script>

<style>
#faih-app {
  display: flex;
  flex-direction: column;
  min-height: 100dvh;
  position: relative;
  z-index: 1;
}

.side-nav-desktop {
  display: flex;
}

.mobile-nav {
  display: none;
}

@media (max-width: 900px) {
  .side-nav-desktop {
    display: none;
  }
  .mobile-nav {
    display: flex;
  }
}
</style>

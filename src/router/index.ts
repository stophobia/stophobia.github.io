import { createRouter, createWebHashHistory } from 'vue-router'
import type { AreaId, TabId } from '@/types'
import { AREAS } from '@/data/areas'

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/area/ai/feed',
    },
    {
      path: '/area/:areaId/:tabId?',
      name: 'area',
      component: () => import('@/views/AreaView.vue'),
      props: true,
      beforeEnter(to) {
        const areaId = to.params.areaId as AreaId
        const area = AREAS.find((a) => a.id === areaId)
        if (!area) return { path: '/area/ai/feed' }

        const tabId = (to.params.tabId as TabId) || area.tabs[0]
        if (!area.tabs.includes(tabId)) {
          return { path: `/area/${areaId}/${area.tabs[0]}` }
        }
      },
    },
    {
      path: '/search',
      name: 'search',
      component: () => import('@/views/SearchView.vue'),
    },
    {
      path: '/people/:id',
      name: 'person',
      component: () => import('@/views/PersonView.vue'),
      props: true,
    },
    {
      path: '/organizations/:id',
      name: 'organization',
      component: () => import('@/views/OrganizationView.vue'),
      props: true,
    },
    {
      path: '/favorites',
      name: 'favorites',
      component: () => import('@/views/FavoritesView.vue'),
    },
    {
      path: '/:pathMatch(.*)*',
      redirect: '/',
    },
  ],
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0, behavior: 'smooth' }
  },
})

export default router

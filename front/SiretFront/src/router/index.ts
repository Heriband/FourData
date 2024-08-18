import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: { path: "/list" }, 
    },
    {
      path: '/list',
      name: 'list',
      component: () => import('../views/listView.vue')
    },
    {
      path: '/add',
      name: 'add entreprise',
      component: () => import('../views/addEntrepriseView.vue')
    },
    {
      path: '/:id/edit',
      name: 'edit entreprise',
      component: () => import('../views/EditVue.vue')
    },


  ]
})

export default router

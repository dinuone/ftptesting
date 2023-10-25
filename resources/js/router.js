import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/ftp/index',
      name: 'ftp.index',
      component: () => import('./views/FTP/Index.vue'),
    },
    {
      path: '/ftp/:id',
      name: 'ftp.view',
      component: () => import('./views/FTP/View.vue'),
    },

  ],
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})

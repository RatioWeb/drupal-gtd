import Vue from 'vue'
import Router from 'vue-router'
import Front from '@/components/Front'
import Node from '@/components/Node'

Vue.use(Router)

export default new Router({
  mode: 'history',
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      return { selector: to.hash }
    }
    return {x: 0, y: 0}
  },
  routes: [
    {
      path: '/',
      name: 'Front',
      component: Front
    },
    {
      path: '/node/:nid',
      name: 'Node',
      component: Node,
      props: true
    }
  ]
})

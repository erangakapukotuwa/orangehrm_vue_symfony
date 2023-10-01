import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import EmployeeView from '../views/EmployeeView.vue'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: import.meta.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/employee',
      name: 'employee',
      component: EmployeeView
    }
  ]
})

router.beforeEach((to, from, next) => {
  const publicPages = ['/'];
  const authRequired = !publicPages.includes(to.path);
  const currentUser = JSON. parse(localStorage.getItem("currentUser"));
  const isAuthenticated = currentUser && currentUser.token ? true : false;
  if (authRequired && !isAuthenticated) {
    return next('/');
  }
  next();
})

export default router

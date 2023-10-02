import Vue from 'vue'
import { createPinia, PiniaVuePlugin } from 'pinia'
import { BootstrapVue } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import config from './config'

import App from './App.vue'
import router from './router'
import store from "./stores"

Vue.use(PiniaVuePlugin)
Vue.use(BootstrapVue)

new Vue({
  router,
  pinia: createPinia(),
  render: (h) => h(App),
  store,
  config
}).$mount('#app');

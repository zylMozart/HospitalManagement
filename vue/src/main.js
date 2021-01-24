// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import axios from 'axios'
import echarts from 'echarts'
import VueCookies from 'vue-cookies'
import Vuex from 'vuex'
import store from './vuex/store'

Vue.use(VueCookies)
Vue.use(Vuex)
Vue.use(ElementUI)
Vue.config.productionTip = false

/* eslint-disable no-new */
// axios.defaults.baseURL = ''
// Vue.prototype.HOST = '/api'
Vue.prototype.$axios = axios
Vue.prototype.$echarts = echarts
new Vue({
  el: '#app',
  render: h=>h(App),
  router,
  axios,
  store,
  components: { App },
  template: '<App/>'
})

import {ifAuthLoadUser} from "./utils/auth";

require('dotenv').config({
  path: '../.env'
})
import Vue from 'vue'
import './plugins/axios'
import './assets/scss/app.scss'
import 'vue-toast-notification/dist/theme-sugar.css';
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import VueToast from 'vue-toast-notification';


(async function () {

  await ifAuthLoadUser()

  Vue.config.productionTip = false

  Vue.use(VueToast,{
    position: 'top-right'
  })

  new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
  }).$mount('#app')
}) ()



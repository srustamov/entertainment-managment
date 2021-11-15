import {ifAuthLoadUser} from "./utils/auth";

require('dotenv').config({
  path: '../.env'
})

window._ = require('lodash');

import Vue from 'vue'
import './plugins/axios'
import './assets/scss/app.scss'
import 'vue-toast-notification/dist/theme-sugar.css';
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import VueToast from 'vue-toast-notification';
import useI18n from './plugins/i18n';


import vuetify from './plugins/vuetify'

(async function () {

  await ifAuthLoadUser()

  const i18n = await useI18n();

  Vue.config.productionTip = false

  Vue.use(VueToast,{position: 'top-right'})

  new Vue({
    router,
    store,
    vuetify,
    i18n,
    render: h => h(App)
  }).$mount('#app')
}) ()



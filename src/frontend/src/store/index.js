import Vue from 'vue'
import Vuex from 'vuex'
import states from "./states";
import mutations from "./mutations";
import actions from "./actions";
import getters from "./getters";

//modules
import queue from "./modules/queue";
import activity from "./modules/activity";

Vue.use(Vuex)

export default new Vuex.Store({
  state: states,
  getters: getters,
  mutations: mutations,
  actions: actions,
  modules: {
    queue : queue,
    activity : activity,
  }
})

import $axios from "../../plugins/axios";
import {queues, queuesStatuses} from "../../utils/routes";
import Vue from "vue";

export default {
    namespaced:true,
    namespace:true,
    state:{
        list:{
            data:[]
        },
        statuses:[]
    },
    getters:{
        list: state => state.list,
        statuses: state => state.statuses
    },
    actions:{
        async fetch({state},params) {
            const response = await $axios.get(queues,{
                params
            });
            if (response?.success) {
                return state.list = response.data
            }
        },
        async fetchStatuses({state}) {
            const response = await $axios.get(queuesStatuses);
            if (response?.success) {
                return state.statuses = response.data
            }
        }
    }
}
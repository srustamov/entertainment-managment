import $axios from "../../plugins/axios";
import {queues} from "../../utils/routes";
import Vue from "vue";

export default {
    namespaced:true,
    namespace:true,
    state:{
        list:{
            data:[]
        }
    },
    getters:{
        list: state => state.list
    },
    actions:{
        async fetch({state},params) {
            const response = await $axios.get(queues,{
                params
            });
            if (response?.success) {
                return state.list = response.data
            }

            if (response?.message) {
                Vue.$toast.warning(response.message)
            }
        }
    }
}
"use strict";

import Vue from 'vue';
import axios from "axios";
import store from "../store";
import router from "../router";


let config = {
    baseURL: process.env.VUE_APP_API_URL  || "",
    timeout: 60 * 1000, // Timeout
    // withCredentials: true, // Check cross-site Access-Control
};
const $axios = axios.create(config);

$axios.interceptors.request.use(
    function (config) {

        if (store.getters.isAuthenticated) {
            config.headers['Authorization'] = `Bearer ${store.getters.accessToken}`
        }

        return config;
    },
    function (error) {

        return Promise.reject(error);
    }
);

$axios.interceptors.response.use(
    function (response) {

        if (response?.data) {
            return response.data;
        }

        return response;
    },
    async function (error) {

        let data = error?.response?.data

        if (data && data?.code === 401) {
            await store.dispatch('logout')
            await router.push({name:'login'})
        }

        if (data?.message) {
            Vue.prototype.$message.error(data.message)
        }

       return Promise.reject(data);
    }
);

const Plugin = {
    install: (Vue, options) => {
        Vue.http     = $axios;
        window.axios = $axios;
        Object.defineProperties(Vue.prototype, {
            http: {
                get() {
                    return $axios;
                }
            },
            $http: {
                get() {
                    return $axios;
                }
            },
        });
    }
}

Vue.use(Plugin)

export default Plugin;

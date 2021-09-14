"use strict";

import Vue from 'vue';
import axios from "axios";
import store from "../store";


let config = {
    baseURL: process.env.API_URL || process.env.apiUrl || "",
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
    function ({data}) {

        if (data?.data) {
            return data.data;
        }

        return data;
    },
    function (error) {



        return Promise.reject(error);
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

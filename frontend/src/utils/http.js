"use strict";

import axios from "axios";
import store from '../store';
import {AUTH_LOGOUT} from "../helpers/auth";

axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

let config = {
    baseURL: process.env.API_URL || process.env.apiUrl || '',
    timeout: 10000,
    withCredentials: true,
};

const http = axios.create(config);

http.interceptors.request.use(function(config) {

    if (store.getters.isAuthenticated) {
        config.headers['Authorization'] = `Bearer ${store.getters.accessToken}`
    }

    return config;
    },
    function(error) {

        return Promise.reject(error);
    }
);

http.interceptors.response.use(function(response) {
        return response.data;
    },
    async function(error) {
        if (error.status === 401 && error.config && !error.config.__isRetryRequest) {
            await store.dispatch(AUTH_LOGOUT);
            window.location.href = '/login';
        }
    }
);


export default http;
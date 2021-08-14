"use strict";

import Vue from 'vue';
import http from "../utils/http";


Plugin.install = function(Vue, options) {
  Vue.http = http;
  window.$http = http;
  Object.defineProperties(Vue.prototype, {
    http: {
      get() {
        return http;
      }
    },
    $http: {
      get() {
        return http;
      }
    },
  });
};

Vue.use(Plugin)

export default Plugin;

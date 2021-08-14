import { createStore } from 'vuex'
import {AUTH_ERROR, AUTH_REQUEST, AUTH_SUCCESS,USER_REQUEST,AUTH_LOGOUT} from "../helpers/auth";
import http from "../utils/http";

export default createStore({
  state: {
    auth:{
      token: localStorage.getItem('access_token') || '',
      status:'',
      user:null,
    }
  },
  getters:{
    isAuthenticated: state => !!state.token,
    accessToken:state => state.auth.token,
    authStatus: state => state.auth.status,
    user: state => state.auth.user,
  },
  mutations: {
    [AUTH_REQUEST]: (state) => {
      state.auth.status = 'loading'
    },
    [AUTH_SUCCESS]: (state, {access_token,user}) => {
      state.auth.status = 'success'
      state.auth.token = access_token
      state.auth.user = user
    },
    [AUTH_ERROR]: (state) => {
      state.auth.status = 'error'
    },
    [AUTH_LOGOUT]: (state) => {
      state.auth.status = ''
      state.auth.token = ''
      localStorage.removeItem('access_token');
    },
  },
  actions: {
    [AUTH_REQUEST]: ({commit, dispatch}, user) => {
      return new Promise((resolve, reject) => {
        commit(AUTH_REQUEST)
        $http.post('/auth/login',{...user})
            .then(async (response) => {
              const {success,data : {access_token},user,error,message} = response;
              if (success) {
                localStorage.setItem('access_token', access_token)
                commit(AUTH_SUCCESS, {access_token,user})
                //await dispatch(USER_REQUEST)
              }

              resolve(response)
            })
            .catch(err => {
              commit(AUTH_ERROR, err)
              localStorage.removeItem('access_token')
              reject(err)
            })
      })
    },
    [USER_REQUEST]:({state}) => {
      return new Promise((resolve ,reject) => {
        http.get('auth/user').then(({success,data : {user},code}) => {
          if (success) {
            state.auth.user = user;
            resolve(user)
          } else {
            resolve(null)
          }

        })
            .catch(reject)
      })
    }
  },
  modules: {
  }
})

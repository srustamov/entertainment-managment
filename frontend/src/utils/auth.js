import {user} from "./routes";
import http from '../plugins/axios'
import store from '../store'

export const  ifAuthLoadUser = async() =>  {
    return new Promise((resolve, reject) => {

        if (!store.getters.accessToken) {
            return resolve(false);
        }

        http.get(user).then(async (response) => {
            if (response.success) {
                await store.dispatch('login',response.data)
            } else {
                await store.dispatch('logout')
            }

            resolve(response)


        })
            .catch(async (e) => {
                await store.dispatch('logout')
                reject(e)
            });
    })
}
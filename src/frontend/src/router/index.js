import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import routes from './routes'
import middlewarePipeline from "./middlewarePipeline";

Vue.use(VueRouter)


const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {

    let middlewareGroup = to?.meta?.middleware;

    if (!middlewareGroup) {
        return next()
    } else if(!middlewareGroup.length) {
        return next()
    }

    const context = {to, from, next, store}

    return middlewareGroup[0]({
        ...context,
        next: middlewarePipeline(context, middlewareGroup, 1)
    })
})

export default router

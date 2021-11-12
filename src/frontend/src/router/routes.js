import auth from "./middleware/auth";
import guest from "./middleware/guest";


import Login from "../views/Login";

export default [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            middleware: [ guest ]
        }
    },
    {
        path: '/',
        name: 'dashboard',
        component: () => import("../views/Dashboard"),
        meta: { middleware: [auth] }
    },
    {
        path: '/queues',
        name: 'queues',
        component: () => import("../views/Queues"),
        meta: { middleware: [auth] }
    },
]
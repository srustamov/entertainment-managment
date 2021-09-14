import Home from "../views/Home";
import Login from "../views/Login";
import auth from "./middleware/auth";
import guest from "./middleware/guest";

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
        component: Home,
        meta: { middleware: [auth] }
    },
]
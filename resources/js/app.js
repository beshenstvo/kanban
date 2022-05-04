require('./bootstrap');

import Vue from '../../node_modules/vue';
import VueRouter from '../../node_modules/vue-router';
import App from './components/App.vue';
import Tasks from './components/Tasks';
import Inprocess from './components/Inprocess';
import Completed from './components/Completed';
import Login from './components/Login';
import Registration from './components/Registration';
import Profile from './components/Profile';
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active-link", 
    linkExactActiveClass: "active-link",
    routes: [
        {
            path: '/',
        },
        {
            path: '/tasks',
            name: 'tasks',
            component: Tasks
        },
        {
            path: '/inprocess',
            name: 'inprocess',
            component: Inprocess
        },
        {
            path: '/completed',
            name: 'completed',
            component: Completed
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/login',
            component: Login,
            name: 'login',
        },
        {
            path: '/register',
            component: Registration,
            name: 'register',
        }
    ]
});

router.beforeEach((to, from , next) => {
    const token = localStorage.getItem('x_xsrf_token');

    if(!token) {
        if(to.name === 'login' || to.name === 'register') {
            return next();
        } else {
            return next({
                name: 'login'
            });
        }
    }

    if(to.name === 'login' || to.name === 'register' && token) {
        return next({
            name: 'tasks'
        });
    }

    next();

});


if(document.querySelector("meta[name='user-id']").getAttribute('content') !== null){
    Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
}



const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});

export default router;
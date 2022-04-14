require('./bootstrap');

import Vue from '../../node_modules/vue';
import VueRouter from '../../node_modules/vue-router';
import App from './components/App';
import Tasks from './components/Tasks';
import Inprocess from './components/Inprocess';
import Completed from './components/Completed';
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
        }
    ]
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});

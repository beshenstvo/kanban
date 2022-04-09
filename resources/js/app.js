require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/App';
import Tasks from './components/Tasks';
import Inprocess from './components/Inprocess';
import Completed from './components/Completed';


// window.Vue = require('vue').default;
// window.Vue = require('vue').use;

// Vue.component('app', require('./components/App'))

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
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
        }
    ]
});

const app = new Vue({
    el: '#app',
    component: { App },
    router
});

export default app;
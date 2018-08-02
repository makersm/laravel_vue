require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

import App from './components/App'
import Home from './components/Home'
import Hello from './components/Hello'
import UserItem from './components/UserItem'

import UsersIndex from './views/UsersIndex.vue'
import UsersAdd from './views/UsersAdd.vue'

import axios from 'axios';

Vue.use(VueRouter);
Vue.component('user-item', UserItem);

Vue.prototype.$axios = axios;

var router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'home', component: Home },
        { path: '/hello', name: 'hello', component: Hello, },
        { path: '/users', name: 'users.index', component: UsersIndex },
        { path: '/users/add', name: 'users.add', component: UsersAdd },
    ],
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
})


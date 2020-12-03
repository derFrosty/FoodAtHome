require('./bootstrap');

window.Vue = require('vue');

import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import VueRouter from "vue-router";
import App from './App.vue';
import Vuex from 'vuex'

import LoginComponent from "./Auth/Login.vue";
import RegisterComponent from "./Auth/Register.vue";
import WelcomeComponent from "./Welcome/Welcome.vue";
import ProductComponent from "./Product/Product";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(ClientTable);

Vue.use(Vuex)
Vue.use(VueRouter);

const routes = [
    {path: '/', component: WelcomeComponent},
    {path: '/login', component: LoginComponent},
    {path: '/register', component: RegisterComponent},
    {path: '/products', component: ProductComponent}
]

const router = new VueRouter({
    routes: routes
})

const store = new Vuex.Store({
    state: {
        user: {
            id: null,
            name: null,
            email: null
        }
    },
    mutations: {
        loadUserIfRemembered(state){
            state.user.id = localStorage.getItem('user_id')
            state.user.name = localStorage.getItem('name')
            state.user.email = localStorage.getItem('email')
        },
        setUser (state, user) {
            state.user.id = user.id
            state.user.name = user.name
            state.user.email = user.email
        },
        logoutUser(state){
            state.user.id = null
            state.user.name = null
            state.user.email = null
        }
    }
})

new Vue({
    render: h => h(App),
    router,
    store,
    beforeCreate() {this.$store.commit('loadUserIfRemembered')}
}).$mount('#app');

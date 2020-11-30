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
import UserProfileComponent from "./User/Profile";
import UserChangePasswordComponent from "./User/ChangePassword"

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(ClientTable);

const routes = [
    {path: '/', component: WelcomeComponent},
    {path: '/login', component: LoginComponent},
    {path: '/register', component: RegisterComponent},
    {path: '/products', component: ProductComponent},
    {path: '/profile', component: UserProfileComponent},
    {path: '/profile/changepassword', component: UserChangePasswordComponent}
]

const router = new VueRouter({
    routes: routes
})

const store = new Vuex.Store({
    state: {
        user: {
            id: null,
            name: null,
            email: null,
            nif: null,
            address: null,
            phone: null
        }
    },
    mutations: {
        loadUserIfRemembered(state){
            state.user.id = localStorage.getItem('user_id')
            state.user.name = localStorage.getItem('user_name')
            state.user.email = localStorage.getItem('user_email')
            state.user.nif = localStorage.getItem('user_nif')
            state.user.address = localStorage.getItem('user_address')
            state.user.phone = localStorage.getItem('user_phone')
        },
        setUser (state, user) {
            state.user.id = user.id
            state.user.name = user.name
            state.user.email = user.email
            state.user.nif = user.nif
            state.user.address = user.address
            state.user.phone = user.phone
        },
        logoutUser(state){
            state.user.id = null
            state.user.name = null
            state.user.email = null
            state.user.nif = null
            state.user.address = null
            state.user.phone = null
        }
    }
})

new Vue({
    render: h => h(App),
    router,
    store,
    beforeCreate() {this.$store.commit('loadUserIfRemembered')}
}).$mount('#app');

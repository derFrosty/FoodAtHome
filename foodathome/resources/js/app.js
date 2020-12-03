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
import ShoppingCartComponent from "./User/ShoppingCart";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(ClientTable);

Vue.use(Vuex)
Vue.use(VueRouter);

const routes = [
    {path: '/', component: WelcomeComponent},
    {path: '/login', component: LoginComponent},
    {path: '/register', component: RegisterComponent},
    {path: '/products', component: ProductComponent},
    {path: '/profile', component: UserProfileComponent},
    {path: '/profile/changepassword', component: UserChangePasswordComponent}
    {path: '/shoppingcart', component: ShoppingCartComponent}
]

const router = new VueRouter({
    routes: routes
})

const store = new Vuex.Store({
    state: {
        user: null
    },
    mutations: {
        loadUserIfRemembered(state){
            state.user = JSON.parse(localStorage.getItem('user'))
        },
        setUser (state, user) {
            state.user = user
        },
        logoutUser(state){
            state.user = null
        }
    }
})

new Vue({
    render: h => h(App),
    router,
    store,
    beforeCreate() {this.$store.commit('loadUserIfRemembered')}
}).$mount('#app');

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
import ShoppingCartComponent from "./User/ShoppingCart";
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(ClientTable);
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
    {path: '/profile/changepassword', component: UserChangePasswordComponent},
    {path: '/shoppingcart', component: ShoppingCartComponent}
]

const router = new VueRouter({
    routes: routes
})

const store = new Vuex.Store({
    state: {
        user: null,
        shoppingCart: []
    },
    mutations: {
        loadUserIfRemembered(state) {
            state.user = JSON.parse(localStorage.getItem('user'))
        },
        setUser(state, user) {
            state.user = user
        },
        logoutUser(state) {
            state.user = null
        },
        addProductToShoppingCart(state, product) {
            let newProduct = {
                id: null,
                name: null,
                photo_url: null,
                quantity: null,
                unit_price: null
            }

            newProduct.id = product.id
            newProduct.name = product.name
            newProduct.photo_url = product.photo_url
            newProduct.unit_price = product.price

            //returns object if it's successful, returns undefined if not
            let result = state.shoppingCart.find((value) => value.id === newProduct.id)
            if (result) {
                result.quantity++
            } else {
                newProduct.quantity = 1
                state.shoppingCart.push(newProduct)
            }

        },
        removeProductFromShoppingCart(state, product) {
            let result = state.shoppingCart.findIndex((value) => value.id === product.id)
            if (result != -1) {
                state.shoppingCart.splice(result, 1)
            }
        }
    }
})

new Vue({
    render: h => h(App),
    router,
    store,
    beforeCreate() {
        this.$store.commit('loadUserIfRemembered')
    }
}).$mount('#app');

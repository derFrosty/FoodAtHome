require('./bootstrap');

window.Vue = require('vue');

import VueSocketIO from "vue-socket.io"
Vue.use(
    new VueSocketIO({
        debug: true,
        connection: "http://127.0.0.1:8080"
    })
)

import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import VueRouter from "vue-router";
import App from './App.vue';
import Vuex from 'vuex'
import Toasted from 'vue-toasted';
import Notifications from 'vue-notification'

import LoginComponent from "./Auth/Login.vue";
import RegisterComponent from "./Auth/Register.vue";
import WelcomeComponent from "./Welcome/Welcome.vue";
import ProductComponent from "./Product/Product";
import UserProfileComponent from "./User/Profile";
import UserChangePasswordComponent from "./User/ChangePassword"
import ShoppingCartComponent from "./User/ShoppingCart";
import DeliveryManDashboardComponent from "./deliveryman/DeliveryManDashboard";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(ClientTable);
Vue.use(Notifications)

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(Toasted)

const routes = [
    {path: '/', component: WelcomeComponent},
    {path: '/login', component: LoginComponent},
    {path: '/register', component: RegisterComponent},
    {path: '/products', component: ProductComponent},
    {path: '/profile', component: UserProfileComponent},
    {path: '/profile/changepassword', component: UserChangePasswordComponent},
    {path: '/shoppingcart', component: ShoppingCartComponent},
    {path: '/dashboard/deliveries', component: DeliveryManDashboardComponent}
]

const router = new VueRouter({
    routes: routes
})

const store = new Vuex.Store({
    state: {
        user: null,
        shoppingCart: [],
        orderNotes: ''
    },
    mutations: {
        loadUserIfRemembered(state) {
            state.user = JSON.parse(localStorage.getItem('user'))
            if (state.user) {
                this._vm.$socket.emit('user_logged', state.user)
            }
        },

        setUser (state, user) {
            if (state.user !== user) {
                state.user = user
                if (state.user) {
                    this._vm.$socket.emit('user_logged', state.user)
                }
            }
        },
        logoutUser(state){
            if (state.user) {
                this._vm.$socket.emit('user_logged_out', state.user)
            }
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
                if (state.shoppingCart.length == 0){
                    state.orderNotes = ''
                }
            }
        },
        changeQuantityOfProductInShoppingCart(state, payload){
            let result = state.shoppingCart.findIndex((value) => value.id === payload.product.id)
            if (result != -1) {
                if(Math.round(payload.quantity) <= 0){
                    //delete product from shopping cart if quantity less or equal than 0
                    state.shoppingCart.splice(result, 1)
                }else{
                    state.shoppingCart[result].quantity = Math.round(payload.quantity)
                }

            }
        },
        clearShoppingCart(state){
            state.shoppingCart = []
            state.orderNotes = ''
        },
        changeOrderNotes(state, orderNotes){
            state.orderNotes = orderNotes
        }
    }
})

new Vue({
    render: h => h(App),
    router,
    store,
    beforeCreate() {
        this.$store.commit('loadUserIfRemembered')
    },
    sockets:{
        connect(){
            console.log("Connected!")
        }
    }
}).$mount('#app');

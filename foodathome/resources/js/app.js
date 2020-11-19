require('./bootstrap');

window.Vue = require('vue');

import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import VueRouter from "vue-router";
import App from './App.vue';
import WelcomeComponent from "./Welcome/Welcome.vue";
import ProductComponent from "./Product/Product";

Vue.use(ClientTable);

import LoginComponent from "./Auth/Login.vue";
import RegisterComponent from "./Auth/Register.vue";

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

new Vue({
    render: h => h(App),
    router
}).$mount('#app');

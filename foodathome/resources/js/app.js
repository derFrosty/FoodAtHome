require('./bootstrap');

window.Vue = require('vue');

import {ServerTable, ClientTable, Event} from 'vue-tables-2';
import VueRouter from "vue-router";
import App from './App.vue';
import WelcomeComponent from "./Welcome/Welcome.vue";
import ProductComponent from "./Product/Product";
import MyOrdersComponent from "./Order/MyOrders";
import OrderHistoryComponent from "./Order/OrderHistory";

Vue.use(ClientTable);

Vue.use(VueRouter);
const routes = [
    {path: '/', component: WelcomeComponent},
    {path: '/products', component: ProductComponent},
    {path: '/my_orders', component: MyOrdersComponent},
    {path: '/order_history', component: OrderHistoryComponent}
]

const router = new VueRouter({
    routes: routes
})

new Vue({
    render: h => h(App),
    router
}).$mount('#app');

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router";
import App from './App.vue';
import WelcomeComponent from "./Welcome/Welcome.vue";

Vue.use(VueRouter);
const routes = [
    {path: '/', component: WelcomeComponent},
]

const router = new VueRouter({
    routes: routes
})

new Vue({
    render: h => h(App),
    router
}).$mount('#app');

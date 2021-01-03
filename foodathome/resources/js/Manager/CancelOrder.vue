<template>
    <div>
        <div class="container">
            <div class="jumbotron">
                <h1>{{ title }}</h1>
            </div>
            <order-list :orders="orders" :call="'CancelOrder'"></order-list>
        </div>
    </div>
</template>

<script>
import OrderListComponent from "../Order/OrderList";
export default {
    name: "CancelOrder",
    components:{
        'order-list': OrderListComponent
    },
    data: function () {
        return {
            title: 'Cancel Order',
            orders: []
        }
    },
    methods: {
        getActiveOrders: function () {
            axios.get('api/active_orders')
                .then(response => {
                    this.orders = response.data.data
                })
        }
    },
    mounted() {
        this.getActiveOrders();
    }
}
</script>

<style scoped>

</style>

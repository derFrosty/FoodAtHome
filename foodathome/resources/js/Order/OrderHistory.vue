<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <order-list :orders="orders"></order-list>
    </div>
</template>

<script>
    import OrderListComponent from "./OrderList";

    export default {
        name: "OrderHistory",
        components:{
            'order-list': OrderListComponent
        },
        data: function () {
            return {
                title: 'Order History',
                orders: []
            }
        },
        methods: {
            getOrders: function () {
                axios.get('api/order_history')
                    .then(response => {
                        this.orders = response.data.data
                    })
            }
        },
        mounted() {
            this.getOrders();
        }
    }
</script>

<style scoped>

</style>

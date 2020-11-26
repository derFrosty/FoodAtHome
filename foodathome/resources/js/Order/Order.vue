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
        components:{
            'order-list': OrderListComponent
        },
        data: function () {
            return {
                title: 'My orders',
                orders: []
            }
        },
        methods: {
            getOrders: function () {
                axios.get('api/orders')
                    .then(response => {
                        this.orders = response.data.data
                        //console.log(this.orders)
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

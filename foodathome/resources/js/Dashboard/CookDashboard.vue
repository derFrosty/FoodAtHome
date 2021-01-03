<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <div v-if="isPreparingOrder">
            <div class="container">
                <h2>Preparing Order:</h2>
                <br>
                <h3>Order: {{ this.preparingOrder.order.id }}</h3>
                <h3>Customer's Name: {{ this.preparingOrder.customer.name }}</h3>
                <br>
                <h4>Started preparation at: {{ this.preparingOrder.order.current_status_at }}</h4>
                <div v-if="preparingOrder.order.notes">
                    <h3>Order notes: </h3>
                    <p>{{ preparingOrder.order.notes }}</p>
                </div>

                <h4>Items to prepare: </h4>
                <v-client-table :data="this.preparingOrder.order_items" :columns="columns" :options="options">
                    <template v-slot:photo_url="data">
                        <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
                    </template>
                </v-client-table>

                <div align="right">
                    <button type="button" class="btn btn-success" @click="orderPrepared">Order Prepared</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="text-xl-center">You are not preparing any order.</p>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            title: "Dashboard",
            isPreparingOrder: false,
            preparingOrder: [],
            columns: ['name', 'quantity', 'photo_url'],
            options: {
                filterable: [],
                headings: {
                    'name': 'Product',
                    'photo_url': 'Photo'
                },
                sortable: []
            }
        }
    },
    methods: {
        checkAndGetPreparingOrders: function () {
            axios.get('api/cookdashboard')
                .then(response => {
                    if (response.data.msg == "true") {
                        this.isPreparingOrder = true;
                        this.preparingOrder = response.data.preparing_order;
                    }
                })
        },
        imgSource: function (url) {
            return "storage/products/" + url;
        },
        orderPrepared: function () {
            let order = {
                'id': this.preparingOrder.order.id,
                'status': this.preparingOrder.order.status
            }

            axios.put('api/orderPrepared', order)
                .then(response => {

                    if (response.data.hasOrder < 1){
                        this.preparingOrder = [];
                        this.isPreparingOrder = false;
                    }else{
                        this.checkAndGetPreparingOrders();
                    }

                    this.$forceUpdate();

                })
        }
    },
    mounted() {
        this.checkAndGetPreparingOrders();
    },
    sockets: {
        new_order(payload) {
            this.checkAndGetPreparingOrders();
        }
    }
}
</script>

<style scoped>

</style>

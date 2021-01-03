<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div v-if="order" class="container">
            <div class="row">
                <div class="col-">
                    <img :src="order.customer.photo_url ? 'storage/fotos/' + order.customer.photo_url : 'storage/fotos/template.png'" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;" alt="profile picture">
                </div>
                <div class="col-xl-3 mt-2">
                    <p><strong>Order id</strong>: {{order.id}}</p>
                    <p><strong>Customer name</strong>: {{order.customer.name}}</p>
                    <p><strong>Address</strong>: {{order.customer.customer.address}}</p>
                </div>
                <div class="col-xl-3 mt-2">
                    <p><strong>Phone Number</strong>: {{order.customer.customer.phone}}</p>
                    <p><strong>Customer Email</strong>: {{order.customer.email}}</p>
                    <p><strong>Delivery Started</strong>: {{order.time_elapsed_since_status}} minutes ago</p>
                </div>
                <div class="col-xl-3 mt-2">
                    <p><strong>Delivery Started At</strong>: {{order.current_status_at}}</p>
                    <p><strong>Notes</strong>: {{order.notes}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-">
                    <img style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; visibility: hidden" alt="profile picture">
                </div>
                <div class="col-xl-3 mt-5">
                    <h2>Order</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-">
                    <img style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; visibility: hidden" alt="profile picture">
                </div>
                <div v-for="order_item in order.order_items" class="col-xl-3 mt-2">
                    <p><strong>product</strong>: {{order_item.product.name}}</p>
                    <p><strong>Quantity</strong>: {{order_item.quantity}}</p>
                    <p><strong>Unit price</strong>: {{order_item.unit_price}}</p>
                    <p><strong>Total sub price</strong>: {{order_item.sub_total_price}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-">
                    <img style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; visibility: hidden" alt="profile picture">
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <h2>Total order price: {{order.total_price}}</h2>
                </div>
                <div class="col-xl-2">
                    <button @click="delivered" type="button" class="btn btn-success"><strong>Confirm Delivery</strong></button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "OrderToDeliver",
    props: ["order"],
    data: function (){
        return {
            title: "Order to Deliver"
        }
    },
    methods:{
        delivered: function (){
            this.$emit('order-delivered')
        }
    }
}
</script>

<style scoped>

</style>

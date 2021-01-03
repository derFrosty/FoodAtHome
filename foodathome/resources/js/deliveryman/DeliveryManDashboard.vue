<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <orders-ready-for-delivery v-if="availability" :orders="orders_ready" @order-selected="assignOrder">
        </orders-ready-for-delivery>
        <order-to-deliver v-else :order="my_order" @order-delivered="deliveredOrder">
        </order-to-deliver>
    </div>
</template>

<script>
import OrdersReadyForDelivery from "./OrdersReadyForDelivery";
import OrderToDeliver from "./OrderToDeliver";

export default {
    name: "DeliveryManDashboard",
    components: {OrderToDeliver, OrdersReadyForDelivery},
    data: function (){
        return {
            title: 'Deliveryman Dashboard',
            orders_ready: [],
            my_order: null,
            availability: null
        }
    },
    methods: {
        startup: function (){
            axios.get('/api/availability').then(resp=>{
                this.availability = (resp.data !== 'Not available');
                if (this.availability){
                    axios.get('/api/getReadyOrders').then(resp => {
                        this.orders_ready = resp.data.data;
                    })
                }else{
                    axios.get('/api/currently_delivering').then(resp => {
                        console.log("currently delivering")
                        console.dir(resp.data.data[0])
                        this.my_order = resp.data.data[0]
                    })
                }
            }).catch(error=>{
                console.log("error on availability")
            })
        },
        assignOrder: function (order_id){
            axios.put('/api/deliverorder', {"order_id": order_id}).then(resp=>{

                this.my_order = resp.data.order[0];
                this.availability = null;
                this.$notify({
                    title: 'New delivery!',
                    type: 'success',
                    text: 'You have something to delivery!',
                    duration: 7500,
                    speed: 500
                });
            }).catch(error=>{
                console.log("ERROR!")
            })
        },
        deliveredOrder: function (){
            axios.put('/api/orderDelivered').then(resp=>{
                console.log("order delivered!");
                this.startup();

            })
        }

    },
    computed: {

    },
    mounted() {
        this.startup()

    }
}
</script>

<style scoped>

</style>

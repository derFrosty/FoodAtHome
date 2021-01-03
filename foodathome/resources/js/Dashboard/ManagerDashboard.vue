<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div>
            <div class="row">
                <div class="col-xl-6">
                    <h2 class="ml-5">Users</h2>
                    <v-app v-if="onlineUsers.length > 0" id="inspire">
                        <v-data-table
                            :headers="userHeaders"
                            :items="onlineUsers"
                            item-key="id"
                            hide-default-footer
                            @click:row="(item, slot) => slot.expand(!slot.isExpanded)"
                        >

                            <template v-slot:item.photo_url="{ headers, item }">
                                <img :src="item.photo_url ? 'storage/fotos/' + item.photo_url : 'storage/fotos/template.png'" style="width:75px; height:75px; float:left; border-radius:50%; margin-right:25px;" alt="profile picture">
                            </template>

                        </v-data-table>
                    </v-app>
                    <div v-else class="d-flex justify-content-center mt-5">
                        <h2>There are no online users at the moment!</h2>
                    </div>
                </div>
                <div class="col-xl-6">
                    <h2 class="ml-5">Orders</h2>
                    <v-app v-if="activeOrders.length > 0" id="inspire">
                        <v-data-table
                            :headers="orderHeaders"
                            :items="activeOrders"
                            item-key="id"
                            single-expand
                            hide-default-footer
                            @click:row="(item, slot) => slot.expand(!slot.isExpanded)"
                        >

                            <template v-slot:item.cancel_order="{item}">
                                <button type="button" class="btn btn-secondary" @click.prevent="cancelOrder(item)">Cancel Order</button>
                            </template>

                            <template v-slot:expanded-item="{ headers, item }">
                                <td :colspan="headers.length" class="container">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <strong>Customer</strong>: <p>{{ item.customer.name }}</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <strong>Phone number</strong>: <p>{{ item.customer.customer.phone }}</p>
                                        </div>
                                    </div>
                                </td>
                            </template>

                        </v-data-table>
                    </v-app>
                    <div v-else class="d-flex justify-content-center mt-5">
                        <h2>There are no orders at the moment!</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "ManagerDashboard",
    data: function (){
        return {
            title: "Manager Dashboard",
            onlineUsers: [],
            activeOrders: [],
            userHeaders: [
                {
                    text: 'User id',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                { text: 'Photo', value: 'photo_url' },
                { text: 'Name', value: 'name' },
                { text: 'Status', value: 'currently' }
            ],
            orderHeaders: [
                {
                    text: 'Order id',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                { text: 'Status', value: 'status' },
                { text: 'Currently handled by', value: 'handler' },
                { text: 'Waiting for since', value: 'current_status_at'},
                { text: '', value: 'cancel_order' }
            ]
        }
    },
    methods: {
        getOnlineUsers: function (){
            axios.get('/api/getworkers').then(resp=>{
                this.onlineUsers = resp.data.data
            })
        },
        getActiveOrders: function (){
            axios.get('/api/activeorders').then(resp=>{
                this.activeOrders = resp.data.data
            })
        },
        cancelOrder(order) {
            axios.put('api/cancelOrder/' + order.id)
                .then(response => {
                    this.reload();
                    this.$toasted.success('Order canceled',
                        {
                            duration: 2000,
                            position: 'bottom-center'
                        });
                })
        },
        reload(){
            this.getOnlineUsers();
            this.getActiveOrders();
        }
    },
    created() {
        this.reload();
    },
    sockets: {
        update_incoming(payload) {
            this.reload();
        }
    }
}
</script>

<style scoped>

</style>

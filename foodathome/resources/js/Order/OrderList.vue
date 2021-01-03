<template>
    <div>
        <v-app id="inspire">
            <v-data-table
                :headers="tableHeaders"
                :items="orders"
                item-key="id"
                single-expand
                :items-per-page="5"
                @click:row="(item, slot) => slot.expand(!slot.isExpanded)"
            >

                <template v-if="call" v-slot:item.button_cancel="{ headers, item }">
                    <button type="button" class="btn btn-danger btn-sm" @click="cancelOrder(item)">Cancel Order</button>
                </template>
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length" class="container">
                        <div class="row">
                            <div class="col-xl-3">
                                <p v-for="i in item.order_items">{{ i.quantity + "x " + i.product.name }}</p>
                            </div>
                        </div>
                    </td>
                </template>
            </v-data-table>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: "OrderList",
        props: ['orders', 'call'],
        data: function () {
            return {
                tableHeaders: [
                    {
                        text: 'Order number',
                        align: 'start',
                        sortable: false,
                        value: 'id',
                    },
                    { text: 'Status', value: 'status' },
                    { text: 'Notes', value: 'notes' },
                    { text: 'Total Price', value: 'total_price' },
                    { text: 'Date', value: 'date' },
                    { text: '', value: 'button_cancel' }
                ],
            }
        },
        methods: {
            cancelOrder(order) {
                axios.put('api/cancelOrder/' + order.id)
                    .then(response => {
                        this.$toasted.success('Order canceled',
                            {
                                duration: 2000,
                                position: 'bottom-center'
                            });
                    })
            }
        }
    };
</script>

<style scoped>

</style>

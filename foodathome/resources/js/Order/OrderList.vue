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
        props: ['orders'],
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
                    { text: 'Date', value: 'date' }
                ],
            }
        },
        methods: {
        }
    };
</script>

<style scoped>

</style>

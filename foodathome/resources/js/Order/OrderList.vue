<template>
    <div>
        <v-client-table :data="orders" :columns="columns" :options="options">
            <template v-slot:status="data">
                <a>{{ statusSource(data.row.status) }}</a>
            </template>
            <template v-slot:notes="data">
                <a>{{ notesSource(data.row.notes) }}</a>
            </template>
            <template v-slot:total_price="data">
                <a>{{ totalPriceSource(data.row.total_price) }}</a>
            </template>
            <template v-slot:detail="data">
                <a class="btn btn-xs btn-info" v-on:click="moreDetails(data.row)">MoreDetails</a>
            </template>
        </v-client-table>
    </div>
</template>

<script>
    export default {
        props: ['orders'],
        data: function () {
            return {
                showDialog: false,
                columns: ['id', 'status', 'notes', 'total_price', 'date', 'detail'],
                options: {
                    filterable: [],
                    sortable: ['id', 'status', 'total_price', 'date']
                },
                products: []
            }
        },
        methods: {
            statusSource: function (status) {
                switch (status) {
                    case "H" : return "Holding";
                    case "P" : return "Preparing";
                    case "R" : return "Ready";
                    case "T" : return "In transit";
                    case "D" : return "Delivered"
                    case "C" : return "Cancelled";
                    default : return "Other"
                }
            },

            notesSource: function (notes) {
                return (notes == null ? "No notes" : notes);
            },

            totalPriceSource: function (totalPrice) {
                return totalPrice + "€";
            },

            moreDetails: function (order) {

                axios.get('api/getproducts/' + order.id)
                    .then(response => {
                        this.products = response.data
                        this.products.forEach(product => this.$toasted.show(product.name, {duration: 2000}));
                    })
            },
        }
    };
</script>

<style scoped>

</style>

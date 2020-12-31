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
                }
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
                order.preparation_time != null ?
                    this.$toasted.show("Preparation time: " + order.preparation_time, {duration: 2000})
                    : this.$toasted.show("Preparation time: Sem valor", {duration: 2000})

                order.delivery_time != null ?
                    this.$toasted.show("Delivery time: " + order.delivery_time, {duration: 2000})
                    : this.$toasted.show("Delivery time: Sem valor", {duration: 2000})

                order.total_time != null ?
                    this.$toasted.show("Total time: " + order.total_time, {duration: 2000})
                    : this.$toasted.show("Total time: Sem valor", {duration: 2000})
            },
        }
    };
</script>

<style scoped>

</style>

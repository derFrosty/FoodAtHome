<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <div v-if="products.length != 0">
            <v-client-table :data="products" :columns="columns" :options="options">
                <template v-slot:photo_url="data">
                    <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
                </template>
                <template v-slot:unit_price="data">
                    <p>{{data.row.unit_price}}€</p>
                </template>
                <template v-slot:total_price="data">
                    <p>{{total_price_per_product(data.row)}}€</p>
                </template>
            </v-client-table>
        </div>
        <div v-else>
            <p class="text-xl-center">There are no items on you shopping cart</p>
        </div>

    </div>
</template>

<script>
export default {
    data: function () {
        return {
            title: 'Shopping Cart',
            products: [],
            columns: ['photo_url', 'name', 'quantity', 'unit_price', 'total_price', 'options'],
            options: {
                filterable: ['name'],
                headings: {
                    'name': 'Product',
                    'photo_url': 'Photo',
                    'options': ''
                },
                sortable: []
            },

        }
    },
    methods: {
        imgSource: function (url) {
            return "storage/products/" + url;
        },
        total_price_per_product: function (product){
            let total = product.unit_price * product.quantity
            return total.toFixed(2)
        }
    },
    mounted() {
        if (this.$store.state.shoppingCart.length != 0) {
            this.products = this.$store.state.shoppingCart
        }
    }
}
</script>

<style scoped>

</style>

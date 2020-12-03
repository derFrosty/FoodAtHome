<template>
    <div>
        <div v-if="products.length != 0">
            <v-client-table :data="products" :columns="columns">
                <template v-slot:photo_url="data">
                    <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
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
            products: [],
            columns: ['photo_url', 'name', 'quantity', 'options'],
            headings: {
                'name': 'Product',
                'photo_url': 'Photo',
                'options': ''
            },

        }
    },
    methods: {
        imgSource: function (url) {
            return "storage/products/" + url;
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

<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <div v-if="products.length != 0">
            <b-button variant="danger" @click="clearShoppingCart">Clear Shopping Cart</b-button>
            <v-client-table :data="products" :columns="columns" :options="options">
                <template v-slot:photo_url="data">
                    <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
                </template>
                <template v-slot:unit_price="data">
                    <p>{{ data.row.unit_price }}€</p>
                </template>
                <template v-slot:total_price="data">
                    <p>{{ total_price_per_product(data.row) }}€</p>
                </template>
                <template v-slot:options="data">
                    <div>
                        <b-input class="d-inline" type="number" style="width: 80px" step="1"
                                 :value="data.row.quantity" @change="quantityChange(data.row, $event)"></b-input>
                        <b-button variant="transparent" class="d-inline" style="margin-left: 10px">
                            <b-icon icon="trash" variant="danger rounded"
                                    @click="deleteProductFromCart(data.row)"></b-icon>
                        </b-button>
                    </div>
                </template>
            </v-client-table>

            <div>
                <p>Order notes:</p>
                <b-form-textarea
                    id="textarea-small"
                    size="sm"
                    placeholder="Please specify any specific changes to your order..."
                    v-model="orderNotes"
                    @update="changeOrderNotes(orderNotes)"
                ></b-form-textarea>
            </div>

            <div align="right">
                <p >Total: {{ calculate_total_price }}€</p>
                <button type="button" class="btn btn-success" @click="confirmOrder">Confirm Order</button>
            </div>

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
            orderNotes: '',
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
        total_price_per_product: function (product) {
            let total = product.unit_price * product.quantity
            return total.toFixed(2)
        },
        deleteProductFromCart: function (product) {
            this.$store.commit('removeProductFromShoppingCart', product)
        },
        quantityChange: function (product, newQuantity) {
            this.$store.commit('changeQuantityOfProductInShoppingCart', {product: product, quantity: newQuantity})
        },
        clearShoppingCart: function (){
            this.$store.commit('clearShoppingCart');

            this.products = this.$store.state.shoppingCart
        },
        changeOrderNotes: function (notes){
            this.$store.commit('changeOrderNotes',notes)
        },
        confirmOrder: function (products, orderNotes){
            let order = {
                products: this.products,
                orderNotes : this.orderNotes
            }

            axios.post('/api/confirmorder', order)
            .then( response => {
                if (response.status === 200){
                    this.$store.commit('changeOrderNotes','');
                    this.$store.commit('clearShoppingCart');
                    this.$toasted.success('Order placed',
                        {
                            duration: 2000,
                            position: 'bottom-center'
                        });
                    this.$forceUpdate();
                    this.products = []
                    axios.get('/api/checkorder/'+response.data.order_id).then(resp => {
                        if(resp.data.order_cook_id){
                            //socket
                            this.$socket.emit('order_placed_on_online_cook', resp.data.order_cook_id)
                        }else{
                            this.$socket.emit('new_order_placed');
                        }

                    })

                }
            })
            .catch( resposnse => {
                this.$toasted.error('Forbidden',
                    {
                        duration: 2000,
                        position: 'bottom-center'
                    })
            })

        }

    },
    mounted() {
        if (this.$store.state.shoppingCart.length != 0) {
            this.products = this.$store.state.shoppingCart
        }

        if (this.$store.state.orderNotes != ''){
            this.orderNotes = this.$store.state.orderNotes
        }
    },
    computed: {
        calculate_total_price() {
            let total_sum = 0

            this.products.forEach(value => {
                total_sum += value.unit_price * value.quantity
            })

            return Math.round(total_sum * 100) / 100
        }
    }
}
</script>

<style scoped>

</style>

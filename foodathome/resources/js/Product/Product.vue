<template>
    <div class="container" style="padding-left: 15%; padding-right: 15%">
        <div v-if="!productSelected" class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <prod-list v-if="isManager && !updatingProduct" :products="products" @product-delete="deleteProduct" @product-update="updateProduct"></prod-list>
        <prod-card v-if="(isCustomer || isGuest) && !updatingProduct" :products="products"></prod-card>
        <prod-creation v-if="updatingProduct" :product="productSelected" @back="cancelUpdate" @success="updateSuccess"></prod-creation>

    </div>
</template>

<script>
import ProductListComponent from "./ProductList"
import ProductCardComponent from "./ProductCard"
import ProductCreation from "../Manager/ProductCreation";

export default {
    components: {
        'prod-list': ProductListComponent,
        'prod-card': ProductCardComponent,
        'prod-creation': ProductCreation
    },
    data: function () {
        return {
            title: 'Menu',
            products: [],
            updatingProduct: false,
            productSelected: null
        }
    },
    methods: {
        getProducts: function () {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data.data
                })
        },
        deleteProduct: function (id){
            axios.delete('api/deleteProduct/'+id ).then(resp=>{
                this.getProducts()
            })
        },
        updateProduct: function (data){
            this.productSelected = data;
            this.updatingProduct = true;
        },
        cancelUpdate: function (){
            this.productSelected = null;
            this.updatingProduct = false;
        },
        updateSuccess: function (){
            this.getProducts();
            this.cancelUpdate();
        }
    },
    computed: {
        isCustomer: function () {
            return this.$store.state.user && this.$store.state.user.type == 'C'
        },
        isManager: function () {
            return this.$store.state.user && this.$store.state.user.type == 'EM'
        },
        isGuest: function (){
            return this.$store.state.user == null;
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>

<style scoped>

</style>

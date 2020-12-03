<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
<!--        <prod-list :products="products"></prod-list>-->
        <prod-card :products="products"></prod-card>
    </div>
</template>

<script>
import ProductListComponent from "./ProductList"
import ProductCardComponent from "./ProductCard"

export default {
    components:{
        'prod-list': ProductListComponent,
        'prod-card': ProductCardComponent
    },
    data: function () {
        return {
            title: 'Menu',
            products: []
        }
    },
    methods: {
        getProducts: function () {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data.data
                })
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>

<style scoped>

</style>

<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <prod-list :products="products"></prod-list>
    </div>
</template>

<script>
import ProductListComponent from "./ProductList";

export default {
    components:{
        'prod-list': ProductListComponent
    },
    data: function () {
        return {
            title: 'List of products',
            products: []
        }
    },
    methods: {
        getProducts: function () {
            axios.get('api/products')
                .then(response => {
                    this.products = response.data.data
                    //console.log(this.products)
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

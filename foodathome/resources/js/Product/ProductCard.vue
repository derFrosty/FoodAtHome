<template>
    <div>
        <p>Filter by type of dish</p>
        <b-form-select v-model="typeSelected" :options="typeOfProducts"></b-form-select>
        <p style="margin-top: 10px">Filter by name of dish</p>
        <input type="text" id="myInput" v-model="textFilter" placeholder="Enter name of dish..."
               style="width: 400px; margin-bottom: 10px">
        <div class="row float-left">
            <div v-for="item in filteredProducts" :key="item.id" class="card col-3">
                <img class="card-img-top" :src="imgSource(item.photo_url)" alt="Card image cap" style="max-height: 100px">
                <div class="card-body">
                    <h5 class="card-title">{{ item.name }}</h5>
                    <p class="card-text">{{ typeDish(item.type) }}</p>
                    <p class="card-text">{{ item.description }}</p>
                    <a href="#" class="btn btn-primary">Add to cart</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['products'],
    data: function () {
        return {
            typeOfProducts: [
                {value: 'all products', text: 'All Products'},
                {value: 'hot dish', text: 'Hot Dish'},
                {value: 'cold dish', text: 'Cold Dish'},
                {value: 'drink', text: 'Drink'},
                {value: 'dessert', text: 'Dessert'},
            ],
            typeSelected: 'all products',
            textFilter: ''
        };
    },
    methods: {
        imgSource: function (url) {
            return "storage/products/" + url
        },
        typeDish: function (type) {
            let typeToReturn = null
            this.typeOfProducts.forEach((value) => {
                if (value.value == type) {
                    typeToReturn = value.text
                }
            })
            return typeToReturn
        }
    },
    computed: {
        filteredProducts: function () {

            if (this.typeSelected == 'all products' && (this.textFilter == null || this.textFilter == '')) {
                return this.products
            }

            return this.products.filter((value) => {
                let type = value.type == this.typeSelected || this.typeSelected == 'all products'

                if (!type) {
                    return false
                }

                if (value.name.toLowerCase().includes(this.textFilter.toLowerCase())) {
                    return true
                }
                return false
            })

        }
    }
}
</script>

<style scoped>

</style>

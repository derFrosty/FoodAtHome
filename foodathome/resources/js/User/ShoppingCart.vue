<template>
    <div>
        <div v-if="products">
            <v-client-table :data="products" :columns="columns"></v-client-table>
        </div>
        <div v-else>
            <p>There are no items on you shopping cart</p>
        </div>

    </div>
</template>

<script>
export default {
    data: function (){
        return {
            products: [],
            columns: ['photo_url', 'name' , 'quantity', 'options'],
            headings: {
                'name': 'Product',
                'photo_url': 'Photo',
                'options': ''
            },

        }
    }
}
</script>

<style scoped>

</style>

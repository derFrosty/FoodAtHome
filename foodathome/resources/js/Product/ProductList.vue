<template>
    <div>

        <v-client-table :data="products" :columns="columns" :options="options">
            <template v-slot:photo_url="data">
                <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
            </template>
            <template v-slot:actions="data">
<!--                <p>{{ data.row.id }}</p>-->
                <button type="button" class="btn btn-info w-100" @click="updateProduct(data.row)">Update</button>
                <button type="button" class="btn btn-danger w-100 mt-1" @click="deleteProduct(data.row.id)">Delete</button>
            </template>
        </v-client-table>

    </div>
</template>

<script>
export default {
    props: ['products'],
    data: function () {
        return {
            columns: ['id', 'name', 'type', 'price' ,'description', 'photo_url', 'actions'],
            options: {
                filterable: ['name','type'],
                headings: {
                    'name': 'Product',
                    'photo_url': 'Photo'
                },
                sortable: []
            }
        }
    },
    methods: {
        imgSource: function (url) {
            return "storage/products/" + url;
        },
        deleteProduct: function (id){
            this.$emit('product-delete', id)
        },
        updateProduct: function (data){
            this.$emit('product-update', data)
        }
    }

};
</script>

<template>
    <div>

        <v-client-table :data="products" :columns="columns" :options="options">
            <template v-slot:photo_url="data">
                <!--                <a>{{ data.row.photo_url }}</a>-->
                <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
            </template>
        </v-client-table>

    </div>
</template>

<script>
export default {
    props: ['products'],
    data: function () {
        return {
            columns: ['id', 'name', 'type', 'description', 'photo_url'],
            options: {
                filterable: ['type'],
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
        }
    }

};
</script>

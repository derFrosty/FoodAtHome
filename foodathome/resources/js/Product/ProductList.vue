<template>
    <div>
        <v-client-table :data="products" :columns="columns" :options="options"/>
    </div>
</template>

<script>
export default {
    props: ['products','columns'],
    data: function (){
        return {
            options: {
                filterable: ['type']
            }
        }
    }

};
</script>

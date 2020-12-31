<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div>
            <p class="text-xl-center">There are no items on you shopping cart</p>
        </div>
    </div>
</template>

<script>
export default {
    data: function (){
        return {
            title: "Dashboard"
        }
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>

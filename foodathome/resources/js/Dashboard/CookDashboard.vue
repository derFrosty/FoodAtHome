<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div>
            <p class="text-xl-center">You are not preparing any order.</p>
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

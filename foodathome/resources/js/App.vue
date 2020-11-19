<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light lightbluenavbar">
<!--            <a class="navbar-brand" href="#">Food@Home</a>-->
            <router-link class="navbar-brand" to="/">Food@Home</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
<!--                        <a class="nav-link" href="#">ir para x</a>-->
                        <!-- apagar o <a...> ou comentar, e substituir pela linha abaixo -->
                        <router-link class="nav-link" to="/products">Products</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para y</a>
                        <!-- apagar o <a...> ou comentar, e substituir pela linha abaixo -->
                        <!--                        <router-link class="nav-link" to="/">Food@Home</router-link>-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para z</a>
                        <!-- apagar o <a...> ou comentar, e substituir pela linha abaixo -->
                        <!--                        <router-link class="nav-link" to="/">Food@Home</router-link>-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para w</a>
                        <!-- apagar o <a...> ou comentar, e substituir pela linha abaixo -->
                        <!--                        <router-link class="nav-link" to="/">Food@Home</router-link>-->
                    </li>
                </ul>
            </div>
        </nav>

        <router-view></router-view>

        <footer class="footerbottom">
            <div class="footerstyle py-4">
                <div class="container"><small>Copyright © ipleiria DAD / Food@Home 2020</small></div>
            </div>
        </footer>
    </div>
</template>

<script>


export default {
}
</script>

<style scoped>

</style>

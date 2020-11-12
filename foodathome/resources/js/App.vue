<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
<!--            <a class="navbar-brand" href="#">Food@Home</a>-->
            <router-link class="navbar-brand" to="/">Food@Home</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para x</a>
                        <!-- apagar o a ou comentar -->
<!--                        <router-link class="nav-link" to="/">Food@Home</router-link>-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para y</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para z</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ir para w</a>
                    </li>
                </ul>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>


export default {
}
</script>

<style scoped>
</style>

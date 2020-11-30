<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light lightbluenavbar">

            <router-link class="navbar-brand" to="/">Food@Home</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarColor03" aria-controls="navbarColor03"
                    aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/products">Products</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <!--    mr-auto para que o próximo vá para a direita.      -->
                </ul>
                <ul v-if="!this.$store.state.user.id" class="navbar-nav mr-5">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                </ul>
                <ul v-else class="navbar-nav mr-5">
                    <li class="nav-item">
                        <a class="nav-link" @click="logout">Logout</a>
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
    methods: {
        logout: function () {
            localStorage.removeItem('user_id')
            localStorage.removeItem('name')
            localStorage.removeItem('email')
            this.$store.commit('logoutUser')

            this.$router.push('/')
        }
    },
    computed:{

    }
}
</script>

<style scoped>

</style>

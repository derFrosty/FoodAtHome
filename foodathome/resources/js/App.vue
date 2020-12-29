<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light lightbluenavbar">

            <router-link class="navbar-brand" to="/">Food@Home</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/products">Products</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <!--    mr-auto para que o próximo vá para a direita.      -->
                </ul>
                <ul v-if="!this.$store.state.user" class="navbar-nav mr-5">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                </ul>
                <ul v-else class="navbar-nav dropdown mr-5">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/shoppingcart">
                            <p class="h4 mb-2 d-inline">
                                <b-icon icon="cart4"></b-icon>
                            </p>
                            <p class="h8 d-inline">{{ shoppingCartItemNumber }}</p>
                        </router-link>
                    </li>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ this.$store.state.user.name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" to="/profile">Perfil de utilizador</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" @click="logout">Logout</a>
                    </div>

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
            localStorage.removeItem('user')
            this.$store.commit('logoutUser')

            this.$router.push('/')
        },
        teste: function () {
            console.log(this.$store.state.user.name);
        }
    },
    computed: {
        shoppingCartItemNumber: function () {
            if (this.$store.state.shoppingCart !== undefined && this.$store.state.shoppingCart.length > 0) {

                let sum = 0

                this.$store.state.shoppingCart.forEach(value => {
                    sum += value.quantity
                })

                return sum
            }

            return ''
    },
    sockets: {
        connect() {
            // If user is logged resend the message user_logged
            if (this.$store.state.user) {
                this.$socket.emit('user_logged', this.$store.state.user)
            }
        }
    }
}
</script>

<style scoped>

</style>

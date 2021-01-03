<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                    <div v-if="error" class="alert alert-danger text-center" role="alert">
                        <strong>{{ error }}</strong>
                    </div>
                    <div class="card mt-1">

                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">
                                        E-Mail Address
                                    </label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="loginInfo.email"
                                               name="email" required autocomplete="email" autofocus>
                                        <!--is-invalid ou isInvalid--> <!--value="{{ old('email') }}"-->
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" v-model="loginInfo.password"
                                               class="form-control" name="password" required
                                               autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" v-on:click.prevent="login">Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "login",
    data() {
        return {
            loginInfo: {
                email: '',
                password: ''
            },
            error: null
        }
    },
    methods: {
        login: function () {
            this.error = null
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/login', this.loginInfo).then(response => {
                    axios.get('/api/user').then(response => {
                        //console.log(response.data.customer.nif);
                        this.$store.commit('setUser', response.data)
                        localStorage.setItem('user', JSON.stringify(response.data))

                        switch (true) {
                            case this.isManager() || this.isCustomer():
                                this.$router.push('/products')
                                break
                            case this.isCook():
                                this.$router.push('/dashboard/cook')
                                break;
                            case this.isDeliveryMan():
                                this.$router.push('/dashboard/deliveries')
                                break;
                            default:
                                this.$router.push('/')
                        }

                        axios.put('/api/updateLoggedAt', {
                            "user_id": this.$store.state.user.id,
                            "logged": 1
                        }).then(resp => {
                            axios.put('/api/updateAvailability', {
                                "user_id": this.$store.state.user.id,
                                "availability": 1
                            })
                        })
                    });
                }).catch(error => {
                    this.error = error.response.data.error
                });
            });
        },
        isCustomer: function () {
            if (this.$store.state.user)
                return this.$store.state.user.type === 'C'

            return false
        },
        isDeliveryMan: function () {
            if (this.$store.state.user)
                return this.$store.state.user.type === 'ED'

            return false
        },
        isManager: function () {
            return this.$store.state.user && this.$store.state.user.type === 'EM'
        },
        isCook: function () {
            return this.$store.state.user && this.$store.state.user.type === 'EC'
        }
    }
}
</script>

<style scoped>

</style>

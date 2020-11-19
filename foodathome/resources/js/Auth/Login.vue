<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">
                                        E-Mail Address
                                    </label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="loginInfo.email" :class="{'is-invalid':hasError('email')}" name="email" required autocomplete="email" autofocus> <!--is-invalid ou isInvalid--> <!--value="{{ old('email') }}"-->

                                        <span v-if="hasError('email')" class="invalid-feedback" role="alert">
                                            <strong>{{ getErrorMessage('email') }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" v-model="loginInfo.password" class="form-control" :class="{'is-invalid':hasError('password')}" name="password" required autocomplete="current-password">

                                        <span v-if="hasError('password')" class="invalid-feedback" role="alert">
                                            <strong>{{ getErrorMessage('password') }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" v-on:click.prevent="login">Login</button>
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
        return{
            loginInfo: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        hasError: function(error) {
            return false;
        },
        getErrorMessage: function(error) {
            return 'yes';
        },
        login: function () {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/login', this.loginInfo).then(response=>{
                    axios.get('/api/user').then(response =>{
                        //console.log(response.data.name);
                        
                    });
                });
            });
        }
    }
}
</script>

<style scoped>

</style>

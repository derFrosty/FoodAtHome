<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="fullname" class="col-md-4 col-form-label text-md-right">Fullname</label>

                                <div class="col-md-6">
                                    <input id="fullname" v-model="registerForm.fullname" @keydown="" type="text" class="form-control" :class="{'is-invalid':hasError('name')}" name="name" required autocomplete="name" autofocus>

                                    <span v-if="hasError('name')" class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('name') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" v-model="registerForm.email" type="email" class="form-control" :class="{'is-invalid':hasError('email')}" name="email" required autocomplete="email">

                                    <span v-if="hasError('email')" class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('email') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" v-model="registerForm.password" type="password" class="form-control" :class="{'is-invalid':hasError('password')}" name="password" required>

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('password') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" v-model="registerForm.password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('password_confirmation') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                                <div class="col-md-6">
                                    <input id="address" v-model="registerForm.address" type="text" class="form-control" name="address" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('address') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" v-model="registerForm.phone" type="text" class="form-control" name="phone" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('phone') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nif" class="col-md-4 col-form-label text-md-right">NIF</label>

                                <div class="col-md-6">
                                    <input id="nif" v-model="registerForm.nif" type="text" class="form-control" name="nif" required>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('nif') }}</strong>
                                    </span>
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" v-on:click.prevent="register">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "register",
    data() {
        return{
            registerForm: {
                fullname: '',
                email: '',
                password: '',
                password_confirmation: '',
                type: 'C',
                address: '',
                phone: '',
                nif: ''
            },
            errors: {}
        }
    },
    methods: {
        hasError: function(fieldName) {
            return fieldName in this.errors
        },
        getErrorMessage: function(fieldName) {
            return this.errors[fieldName]
        },
        register: function () {
            axios.post('/api/register', this.registerForm).then(response => {
                    console.log(response);
            }).catch(error => {
                console.log(error.response.data.errors)
                this.errors = error.response.data.errors
                //console.dir(error)
            });
        }
    }
}
</script>

<style scoped>

</style>

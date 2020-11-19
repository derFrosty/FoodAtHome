<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" :class="{'is-invalid':hasError('name')}" name="name" required autocomplete="name" autofocus>

                                    <span v-if="hasError('name')" class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('name') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" :class="{'is-invalid':hasError('email')}" name="email" required autocomplete="email">

                                    <span v-if="hasError('email')" class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('email') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" :class="{'is-invalid':hasError('password')}" name="password" required autocomplete="new-password">

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ getErrorMessage('password') }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
    methods: {
        hasError: function(error) {
            return false;
        },
        getErrorMessage: function(error) {
            return 'yes';
        },
        register: function () {

        }
    }
}
</script>

<style scoped>

</style>

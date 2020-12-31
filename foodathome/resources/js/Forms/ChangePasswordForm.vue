<template>
    <form>

        <div class="form-group row">
            <label for="old_password" class="col-md-4 col-form-label text-md-right">Current password</label>

            <div class="col-md-6">
                <input id="old_password" v-model="inputForm.old_password" type="password" class="form-control" :class="{'is-invalid':hasError('old_password')}" name="old_password" required>

                <span v-for="error in getErrorMessage('old_password')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">New password</label>

            <div class="col-md-6">
                <input id="password" v-model="inputForm.password" type="password" class="form-control" :class="{'is-invalid':hasError('password')}" name="password" required>

                <span v-for="error in getErrorMessage('password')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmation</label>

            <div class="col-md-6">
                <input id="password-confirm" v-model="inputForm.password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <router-link class="btn btn-secondary" to="/profile">Go back</router-link>
                <button type="submit" class="btn btn-primary" v-on:click.prevent="returnData">
                    <div>Update Password</div>
                </button>
            </div>
        </div>

    </form>
</template>

<script>
export default {
    name: "ChangePasswordForm",
    props: ['errors'],
    data() {
        return{
            inputForm: {
                old_password: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    methods: {
        hasError: function(fieldName) {
            return fieldName in this.errors
        },
        getErrorMessage: function(fieldName) {
            return this.errors[fieldName]
        },
        returnData: function (){
            this.$emit('password-changed', this.inputForm)
        }
    }
}
</script>

<style scoped>

</style>

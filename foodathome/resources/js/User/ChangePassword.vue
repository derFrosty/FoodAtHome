<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">

                    <div class="card-header">User Profile</div>

                    <div class="card-body">

                        <change-password-form @password-changed="update" :errors="errors"></change-password-form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChangePasswordForm from "../Forms/ChangePasswordForm";
export default {
    name: "ChangePassword",
    components: {ChangePasswordForm},
    data() {
        return{
            errors: []
        }
    },
    methods: {
        update: function (inputForm){
            console.log(inputForm)
            //update user
        }
    }
}
</script>

<style scoped>

</style>

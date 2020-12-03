<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">

                    <div class="card-header">User Profile</div>

                    <div class="card-body">

                        <UserInformations @user-done="update" :errors="errors"></UserInformations>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

import UserInformations from "../Forms/UserInformations";

export default {
    name: "Profile",
    components: {
        UserInformations
    },
    data() {
        return{
            errors: []
        }
    },
    methods: {
        update: function (inputForm){
            //update user
        }
    }
}
</script>

<style scoped>

</style>

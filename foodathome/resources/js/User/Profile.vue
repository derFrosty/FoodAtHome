<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">

                    <div class="card-header">User Profile</div>

                    <div class="card-body">

                        <UserInformations @user-done="update" :errors="errors" :imageSizeError="imageSizeError"></UserInformations>

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
            errors: [],
            imageSizeError: ""
        }
    },
    methods: {
        update: function (inputForm){
            this.errors = []
            //update user
            axios.post("/api/updateuser", inputForm).then(response => {
                axios.get('/api/user').then(response =>{

                    this.$store.commit('setUser', response.data)
                    localStorage.setItem('user', JSON.stringify(response.data))
                });
            }).catch(error => {
                this.errors = error.response.data.errors
                this.imageSizeError = ""
                if(error.response.statusText === "Request Entity Too Large"){
                    this.imageSizeError = "Image is too big"
                }
            })

        }
    }
}
</script>

<style scoped>

</style>

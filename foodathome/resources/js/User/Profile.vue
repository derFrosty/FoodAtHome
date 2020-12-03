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
            console.log(inputForm)
            //update user

            const data = new FormData()
            if(inputForm.photo != null){
                data.append('photo', inputForm.photo)
            }
            data.append('email', inputForm.email)
            data.append('fullname', inputForm.fullname)
            data.append('password', inputForm.password)
            data.append('address', inputForm.address)
            data.append('phone', inputForm.phone)
            data.append('nif', inputForm.nif)

            console.dir(data)

            axios.post("/api/updateuser", data).then(response => {
                axios.get('/api/user').then(response =>{
                    //console.log(response.data.customer.nif);
                    this.$store.commit('setUser', response.data)
                    localStorage.setItem('user', JSON.stringify(response.data))

                    //this.$router.push('/products')
                });
            }).catch(error => {
                console.log(error)
            })

        }
    }
}
</script>

<style scoped>

</style>

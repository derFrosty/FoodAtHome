<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">

                    <div class="card-header">Register</div>

                    <div class="card-body">

                        <UserInformations @user-done="register" :errors="errors"></UserInformations>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserInformations from "../Forms/UserInformations";
export default {
    name: "register",
    components: {
        UserInformations
    },
    data() {
        return {
            errors: {}
        }
    },
    methods: {
        register: function (inputForm) {
            axios.post('/api/register', inputForm).then(response => {
                //console.log(response);
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/login', {email: inputForm.email, password: inputForm.password}).then(response=>{
                        axios.get('/api/user').then(response =>{
                            //console.log(response.data);
                            this.$store.commit('setUser', response.data)
                            localStorage.setItem('user_id', response.data.id)
                            localStorage.setItem('user_name', response.data.name)
                            localStorage.setItem('user_email', response.data.email)
                            localStorage.setItem('user_nif', response.data.customer.nif)
                            localStorage.setItem('user_phone', response.data.customer.phone)
                            localStorage.setItem('user_address', response.data.customer.address)

                            this.$router.push('/products')
                        });
                    });
                });

            }).catch(error => {
                this.errors = error.response.data.errors
            });
        }
    }
}
</script>

<style scoped>

</style>

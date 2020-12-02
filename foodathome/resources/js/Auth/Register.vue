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
                            localStorage.setItem('user', response.data)

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

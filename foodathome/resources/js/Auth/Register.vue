<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">

                    <div class="card-header">Register</div>

                    <div class="card-body">

                        <UserInformations @user-done="register" :errors="errors" :imageSizeError="imageSizeError"></UserInformations>

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
            errors: [],
            imageSizeError: ""
        }
    },
    methods: {
        register: function (inputForm) {
            var form_email = inputForm.get('email')
            var form_password = inputForm.get('password')

            this.errors = []

            axios.post('/api/register', inputForm).then(response => {
                //console.log(response);
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/login', {email: form_email, password: form_password}).then(response=>{
                        axios.get('/api/user').then(response =>{
                            //console.log(response.data);
                            this.$store.commit('setUser', response.data)
                            localStorage.setItem('user', JSON.stringify(response.data))

                            this.$router.push('/products')
                        });
                    });
                });

            }).catch(error => {
                this.errors = error.response.data.errors
                this.imageSizeError = ""
                if(error.response.statusText === "Request Entity Too Large"){
                    this.imageSizeError = "Image is too big"
                }

            });
        }
    }
}
</script>

<style scoped>

</style>

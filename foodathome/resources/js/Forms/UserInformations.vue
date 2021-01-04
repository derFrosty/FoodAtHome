<template>

    <form>

        <div v-if="$store.state.user" class="form-group row">
            <img class="mx-auto d-block" :src="$store.state.user.photo_url ? 'storage/fotos/' + $store.state.user.photo_url : 'storage/fotos/template.png'" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;" alt="profile picture">
        </div>

        <div class="form-group row">
            <label for="fullname" class="col-md-4 col-form-label text-md-right">Fullname</label>

            <div class="col-md-6">
                <input id="fullname" v-model="inputForm.fullname" type="text" class="form-control" :class="{'is-invalid':hasError('name')}" name="name" required autocomplete="name" autofocus>

                <span v-for="error in getErrorMessage('name')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" v-model="inputForm.email" type="email" class="form-control" :class="{'is-invalid':hasError('email')}" name="email" required autocomplete="email">

                <span v-for="error in getErrorMessage('email')" class="invalid-feedback" role="alert">
                    <strong>{{ error}}</strong>
                </span>
            </div>
        </div>

        <div v-if="inputForm.type == 'C'" class="form-group row">
            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

            <div class="col-md-6">
                <input id="address" v-model="inputForm.address" type="text" class="form-control" :class="{'is-invalid':hasError('address')}" name="address" required>
                <span v-for="error in getErrorMessage('address')" class="invalid-feedback" role="alert">
                    <strong>{{ error}}</strong>
                </span>
            </div>
        </div>

        <div v-if="inputForm.type == 'C'" class="form-group row">
            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>

            <div class="col-md-6">
                <input id="phone" v-model="inputForm.phone" type="text" class="form-control" :class="{'is-invalid':hasError('phone')}" name="phone" required>
                <span v-for="error in getErrorMessage('phone')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div v-if="inputForm.type == 'C'" class="form-group row">
            <label for="nif" class="col-md-4 col-form-label text-md-right">NIF</label>

            <div class="col-md-6">
                <input id="nif" v-model="inputForm.nif" type="text" class="form-control" :class="{'is-invalid':hasError('nif')}" name="nif" required>
                <span v-for="error in getErrorMessage('nif')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

            <div class="col-md-6">
                <input id="password" v-model="inputForm.password" type="password" class="form-control" :class="{'is-invalid':hasError('password')}" name="password" required>

                <span v-for="error in getErrorMessage('password')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
            </div>
        </div>

        <div v-if="!$store.state.user" class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

            <div class="col-md-6">
                <input id="password-confirm" v-model="inputForm.password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="user-photo" class="col-md-4 col-form-label text-md-right">Avatar</label>

            <div v-if="$store.state.user && $store.state.user.photo_url" class="col-md-6">
                <button type="button" class="btn btn-danger btn-sm" @click="removePic">X</button>Remove avatar
            </div>
            <div v-else class="col-md-6">
                <input id="user-photo" class="" type="file" @change="pictureChanged" accept="image/x-png,image/jpg,image/jpeg">
            </div>

        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <router-link v-if="$store.state.user" class="btn btn-secondary" to="/profile/changepassword">Change password</router-link>
                <button type="submit" class="btn btn-primary" v-on:click.prevent="returnData">
                    <div>{{ $store.state.user ? 'Update Information': 'Register'}}</div>
                </button>

            </div>
        </div>

    </form>

</template>

<script>
export default {
    name: "UserInformations",
    props: ['errors'],
    data() {
        return{
            inputForm: {
                fullname: '',
                email: '',
                password: '',
                password_confirmation: '',
                type: 'C',
                address: '',
                phone: '',
                nif: '',
                photo: null
            },

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

            const data = new FormData()
            if(this.inputForm.photo != null){
                data.append('photo', this.inputForm.photo)
            }
            data.append('email', this.inputForm.email)
            data.append('fullname', this.inputForm.fullname)
            data.append('password', this.inputForm.password)
            data.append('type', this.inputForm.type)
            if(!this.$store.state.user){
                data.append('password_confirmation', this.inputForm.password_confirmation)
            }
            if(this.inputForm.type == 'C'){
                data.append('address', this.inputForm.address)
                data.append('phone', this.inputForm.phone)
                data.append('nif', this.inputForm.nif)
            }

            this.$emit('user-done', data)

            this.inputForm.password = '';
            this.inputForm.password_confirmation = '';
        },
        pictureChanged: function (event){
            this.inputForm.photo = event.target.files[0]
        },
        removePic: function (){
            axios.put('/api/removeavatar', {'password': this.inputForm.password}).then(response => {
                this.inputForm.photo = null
                this.$store.commit('setUser', response.data.user)
                localStorage.setItem('user', JSON.stringify(response.data.user))
                console.log(response)
                this.errors = []
            }).catch(error=>{
                this.errors = error.response.data.errors
            })

            this.inputForm.password = '';
            this.inputForm.password_confirmation = '';
        }
    },
    mounted() {
        if(this.$store.state.user){
            this.inputForm.fullname = this.$store.state.user.name;
            this.inputForm.email = this.$store.state.user.email;
            this.inputForm.type = this.$store.state.user.type;

            if(this.inputForm.type == 'C'){
                this.inputForm.address = this.$store.state.user.customer.address;
                this.inputForm.phone = this.$store.state.user.customer.phone;
                this.inputForm.nif = this.$store.state.user.customer.nif;
            }
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="container">
        <div class="jumbotron">
            <h1 v-if="!product">{{ title }}</h1>
            <h1 v-else>Product update</h1>
        </div>
        <form>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                <div class="col-md-6">
                    <input id="name" v-model="inputForm.name" type="text" class="form-control" :class="{'is-invalid':hasError('name')}" name="name" required autocomplete="name" autofocus>

                    <span v-for="error in getErrorMessage('name')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-md-4 col-form-label text-md-right">type</label>

                <div class="col-md-6">
                    <select id="type" v-model="inputForm.type" class="form-control" :class="{'is-invalid':hasError('type')}" required autocomplete="type">
                        <option v-for="type in types">{{type.type}}</option>
                    </select>
                    <span v-for="error in getErrorMessage('type')" class="invalid-feedback" role="alert">
                    <strong>{{ error}}</strong>
                </span>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">description</label>

                <div class="col-md-6">
                    <input id="description" v-model="inputForm.description" type="text" class="form-control" :class="{'is-invalid':hasError('description')}" name="description" required>

                    <span v-for="error in getErrorMessage('description')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
                </div>
            </div>

            <div class="form-group row">
                <label for="price" class="col-md-4 col-form-label text-md-right">price</label>

                <div class="col-md-6">
                    <input id="price" v-model="inputForm.price" type="number" step=".01" class="form-control" :class="{'is-invalid':hasError('price')}" name="price" required>

                    <span v-for="error in getErrorMessage('price')" class="invalid-feedback" role="alert">
                    <strong>{{ error }}</strong>
                </span>
                </div>
            </div>

            <div class="form-group row">
                <label for="photo_url" class="col-md-4 col-form-label text-md-right">Avatar</label>

                <div class="col-md-6">
                    <input id="photo_url" class="" type="file" @change="pictureChanged" accept="image/x-png,image/jpg,image/jpeg">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div v-if="!product" class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary" @click.prevent="submitProduct">
                        Create Product
                    </button>

                </div>
                <div v-else class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary" @click.prevent="submitProduct">
                        <div>Update Product</div>
                    </button>

                    <button type="submit" class="btn btn-secondary w-25" @click.prevent="back">
                        Back
                    </button>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
export default {
    name: "ProductCreation",
    props: ['product'],
    data() {
        return{
            inputForm: {
                id: null,
                name: '',
                type: '',
                description: '',
                photo_url: '',
                price: 0
            },
            errors: [],
            title: 'Product Creation',
            types: []
        }
    },
    methods: {
        hasError: function (fieldName) {
            return fieldName in this.errors
        },
        getErrorMessage: function (fieldName) {
            return this.errors[fieldName]
        },
        pictureChanged: function (event){
            this.inputForm.photo_url = event.target.files[0]
        },
        back: function (){
            this.$emit('back')
        },
        submitProduct: function (){
            this.errors = [];
            const data = new FormData()

            console.log('inputForm->')
            console.log(this.inputForm)

            data.append('name', this.inputForm.name)
            data.append('type', this.inputForm.type)
            data.append('description', this.inputForm.description)
            if(this.inputForm.photo_url !== "" && this.inputForm.photo_url != null){
                data.append('photo_url', this.inputForm.photo_url)
            }

            data.append('price', this.inputForm.price)

            if(this.product == null){
                axios.post("/api/addProduct", data).then(response => {
                    console.log("success POST!?")

                }).catch(error => {
                    this.errors = error.response.data.errors
                })
            }else{
                data.append('id', this.product.id)

                //update do produto não pode ser put por causa da foto
                axios.post("/api/updateProduct", data).then(resp => {
                    this.$emit('success')
                }).catch(error => {
                    this.errors = error.response.data.errors
                })
            }



        },
        getTypes: function (){
            axios.get('api/types').then(resp => {
                this.types = resp.data
            })
        }
    },
    created() {
        this.getTypes();
        if(this.product){
            this.inputForm.name = this.product.name;
            this.inputForm.type = this.product.type;
            this.inputForm.description = this.product.description;
            this.inputForm.price = this.product.price;
        }
    }
}
</script>

<style scoped>

</style>

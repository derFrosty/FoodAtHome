<template>
    <div class="container">
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <v-client-table :data="users" :columns="columns" :options="options">
            <template v-slot:photo_url="data">
                <img style="display:block;" width="auto" height="65" :src="imgSource(data.row.photo_url)">
            </template>
            <template v-slot:blocked="data">
                <p>{{isBlocked(data.row.blocked)}}</p>
            </template>
            <template v-slot:options="data">
                <b-button variant="success">Update</b-button>
                <b-button v-if="$store.state.user && data.row.id != $store.state.user.id"
                          variant="warning">{{ data.row.blocked == 0 ? 'Block' : 'Unblock' }}</b-button>
                <b-button variant="danger">Delete</b-button>
            </template>
        </v-client-table>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            title: 'User List',
            users: [],
            columns: ['photo_url' ,'id', 'name', 'email', 'blocked', 'options'],
            options: {
                filterable: ['name', 'type'],
                headings: {
                    'photo_url': 'Photo',
                    'options': '',
                    'email': 'E-mail'
                },
                sortable: ['id','name','email','blocked']
            }
        }
    },
    methods: {
        getAllUsers: function () {
            axios.get('api/users')
                .then(response => {
                    this.users = response.data.data;
                })
        },
        isBlocked: function (status){
            switch (status){
                case 1:
                    return 'Blocked';
                case 0:
                    return 'Active';
            }
        },
        imgSource: function (url) {
            return url != null ? "storage/fotos/" + url : "storage/fotos/template.png";
        }
    },
    mounted() {
        this.getAllUsers()
    }
}
</script>

<style scoped>

</style>

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
                          variant="warning" @click="changeBlockStatus(data)">{{ data.row.blocked == 0 ? 'Block' : 'Unblock' }}</b-button>
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
        },
        changeBlockStatus: function (rowData){

            axios.post('api/changeBlockStatus', {'id': rowData.row.id})
            .then(response => {
                this.users[rowData.index-1].blocked = response.data.blocked
                //emit changeBlockedStatus
                this.$socket.emit('changeBlockedStatus', this.users[rowData.index-1])
            })
        }
    },
    mounted() {
        this.getAllUsers()
    },
    sockets: {
        updateUserList (payload){

            for (let i = 0; i < this.users.length; i++) {
                //console.log(this.users[i])
                if (this.users[i].id == payload.id){

                    this.users[i].blocked = payload.blocked

                    this.$forceUpdate()
                    break
                }
            }

        }
    }
}
</script>

<style scoped>

</style>

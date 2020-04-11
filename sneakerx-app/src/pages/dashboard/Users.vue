<template>
  <q-page class="column flex-center">
    <h3>Users</h3>
    <UsersList v-if="users" :users="users"></UsersList>
  </q-page>
</template>

<script>
    import UsersList from 'components/admin/users/UsersList.vue'

    export default {
        name: "Users",
        components: {
            UsersList
        },
        data () {
            return {
                users: [],
                loading: false,
            }
        },
        created() {
            this.getUsers()
        },
        mounted() {
        },
        computed: {

        },
        methods: {
            getUsers () {
                this.loading = true
                this.$axios.get('/api/admin/users')
                    .then(response => {
                        console.log(response)
                        this.users = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log('error')
                        console.log(error)
                        this.loading = false
                    })
            }
        }
    }
</script>

<style scoped>

</style>

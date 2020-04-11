<template>
  <q-page class="flex flex-center">
    <h3>Users</h3>
  </q-page>
</template>

<script>
    export default {
        name: "Users",
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

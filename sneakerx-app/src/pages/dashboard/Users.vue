<template>
  <q-page class="column items-center">
    <h3>Users</h3>
    <UsersList></UsersList>
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

            }
        },
        created() {

        },
        mounted() {
        },
        computed: {

        },
        methods: {

        }
    }
</script>

<style scoped>

</style>

<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-teal text-white flex full-width">
        <div class="text-h6">User / List</div>
        <q-space/>
        <div class="flex">
          <q-btn class="q-mr-sm"
                 color="positive"
                 icon="add"
                 label="Add User"
                 @click="addUser"
          />
          <q-btn color="negative"
                 icon="delete"
                 label="Delete Selection"
                 :disable="!selected.length"
                 @click="deleteUsers"
          />
        </div>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <UsersList @selectedChange="changeSelect"></UsersList>
      </q-card-section>
    </q-card>

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
                selected: [],
            }
        },
        created() {
        },
        mounted() {
        },
        computed: {
        },
        methods: {
            changeSelect(selected) {
                this.selected = selected
            },
            addUser() {
                this.$root.$emit('addUser')
            },
            deleteUsers () {
                this.$root.$emit('deleteUsers')
            },
        }
    }
</script>

<style scoped>

</style>

<template>
  <div class="q-pa-md">
    <q-table
      title="Treats"
      :data="users"
      :columns="columns"
      row-key="name"
      selection="multiple"
      :selected.sync="selected"
      :visible-columns="visibleColumns"
      :loading="loading"
    >

      <template v-slot:top>
        <img
          style="height: 50px; width: 50px"
          src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg"
        >

        <q-space />

        <q-input borderless dense debounce="300" v-model="search" placeholder="Search" class="q-mr-md">
          <q-icon slot="append" name="search" />
        </q-input>

        <q-select
          v-model="visibleColumns"
          multiple
          outlined
          dense
          options-dense
          :display-value="$q.lang.table.columns"
          emit-value
          map-options
          :options="columns"
          option-value="name"
          options-cover
          style="min-width: 150px"
        />
      </template>
      <template v-slot:no-data="{ icon, message, filter }">
        <div class="full-width row flex-center text-accent q-gutter-sm">
          <q-icon size="2em" name="sentiment_dissatisfied" />
          <span>
            Well this is sad... {{ message }}
          </span>
          <q-icon size="2em" :name="search ? 'filter_b_and_w' : icon" />
        </div>
      </template>
    </q-table>
  </div>
</template>

<script>
    export default {
        name: "UsersList",
        data() {
            return {
                users: [],
                loading: false,

                search: '',
                selected: [],
                visibleColumns: ['id', 'name', 'email', 'is_admin', 'created_at'],
                columns: [
                    {
                        name: 'id', required: true, label: 'ID',
                        field: row => row.id,
                        format: val => `${val}`,
                        sortable: true
                    },
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'email', label: 'Email', field: 'email', sortable: true},
                    {name: 'email_verified_at', label: 'Verified At', field: 'email_verified_at', sortable: true},
                    {name: 'is_admin', label: 'Admin', field: 'is_admin', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                ],
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

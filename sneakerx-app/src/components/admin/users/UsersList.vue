<template>
  <div class="q-pa-md" id="userList">
    <div class="row full-width q-mb-sm">
      <q-space />
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

    <q-table
      title="Treats"
      :data="users"
      :columns="columns"
      row-key="id"
      selection="multiple"
      :selected.sync="selected"
      :visible-columns="visibleColumns"
      :loading="loading"
      :pagination.sync="pagination" v-if="showTable"
    >

      <template v-slot:top>
        <q-icon name="group" size="lg"/>

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

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td auto-width>
            <q-checkbox v-model="props.selected"
                        :disable="props.row.id === getUserId"
            />
          </q-td>
          <q-td key="id" :props="props">{{ props.row.id }} #</q-td>
          <q-td key="name" :props="props">
            {{ props.row.name }}
            <q-popup-edit v-model="props.row.name">
              <q-input v-model="props.row.name" dense autofocus counter />
            </q-popup-edit>
          </q-td>
          <q-td key="email" :props="props">
            <div class="text-pre-wrap">{{ props.row.email }}</div>
            <q-popup-edit v-model="props.row.email">
              <q-input v-model="props.row.email" dense autofocus counter />
            </q-popup-edit>
          </q-td>
          <q-td key="is_admin" :props="props">
            {{ props.row.is_admin ? 'YES' : 'NO' }}
            <q-popup-edit v-model="props.row.is_admin" title="Update is_admin" buttons persistent>
              <q-input type="number" v-model="props.row.is_admin" dense autofocus hint="Use buttons to close" />
            </q-popup-edit>
          </q-td>
          <q-td key="created_at" :props="props">{{ cFormatDate(props.row.created_at) }}</q-td>
          <q-td key="email_verified_at" :props="props">{{ cFormatDate(props.row.email_verified_at) }}</q-td>
          <q-td key="updated_at" :props="props">{{ cFormatDate(props.row.updated_at) }}</q-td>
        </q-tr>
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
    import { QSpinnerFacebook, QSpinnerGears, date } from 'quasar'

    export default {
        name: "UsersList",
        data() {
            return {
                showTable: false,

                users: [],
                loading: false,
                search: '',

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 6
                    // rowsNumber: xx if getting data from a server
                },
                selected: [],
                visibleColumns: ['id', 'name', 'email', 'is_admin', 'created_at'],
                columns: [
                    {
                        name: 'id', required: true, label: 'ID',
                        field: row => row.id,
                        format: val => `#${val}`,
                        sortable: true
                    },
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'email', label: 'Email', field: 'email', sortable: true},
                    {name: 'is_admin', label: 'Admin', field: 'is_admin', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'email_verified_at', label: 'Verified At', field: 'email_verified_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                ],
            }
        },
        created() {
            this.getUsers()
        },
        mounted() {
            this.showTable = true
        },
        watch: {
            selected (val) {
                let authIndex = this.selected.findIndex(user => user.id === this.getUserId)
                if (authIndex !== -1) this.selected.splice(authIndex, 1)
            }
        },
        computed: {
            getUserId() {
                return this.$store.state.auth.user.id
            }
        },
        methods: {
            cFormatDate (Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
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
            },
            addUser() {

            },
            deleteUsers () {
                let selectedLength = this.selected.length
                let count = 0
                this.$q.loading.show({
                    message: `Deleting Users... (${selectedLength})`
                })
                this.selected.forEach(userSelect => {
                    this.$axios.delete(`/api/admin/users/${userSelect.id}`)
                        .then(response => {
                            console.log(response)
                            count++
                            this.users.splice(this.users.findIndex(user => user.id === userSelect.id), 1)
                            this.selected.splice(this.selected.findIndex(user => user.id === userSelect.id), 1)
                            if (count === selectedLength) this.hideLoading('User(s) Deleted')
                        })
                        .catch(error => {
                            console.log(error)
                            this.hideLoading('An error occurred : ' + error.message)
                        })
                })
            },
            hideLoading (message) {
                this.$q.loading.show({
                    spinner: QSpinnerGears,
                    spinnerColor: 'red',
                    messageColor: 'black',
                    backgroundColor: 'yellow',
                    message: message
                })

                this.timer = setTimeout(() => {
                    this.$q.loading.hide()
                    this.timer = void 0
                }, 2000)
            }
        },
        beforeDestroy () {
            this.$q.loading.hide()
        },
    }
</script>

<style scoped lang="scss">
  #userList {
    max-width: 100%;
  }
</style>

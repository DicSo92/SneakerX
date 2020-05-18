<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="roles"
      :columns="columns"
      row-key="id"
      :loading="loading"
      class="BrandTable"
    >

      <template v-slot:top>
        <q-icon name="local_offer" size="lg"/>

        <q-space/>

        <q-input borderless dense debounce="300" v-model="search" placeholder="Search" class="q-mr-md">
          <q-icon slot="append" name="search"/>
        </q-input>
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            class="text-italic text-purple"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props" @click="props.expand = !props.expand" class="cursor-pointer">
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="name" :props="props" auto-width>
            <div class="text-bold">
              {{props.row.name}}
            </div>
          </q-td>
          <q-td key="description" :props="props" auto-width>
            <div class="text-caption">
              {{props.row.description}}
            </div>
          </q-td>
        </q-tr>

        <q-tr v-show="props.expand" :props="props">
          <q-td colspan="100%">
            <div class="flex no-wrap q-gutter-sm">
              Expand
            </div>
          </q-td>
        </q-tr>
      </template>

      <template v-slot:no-data="{ icon, message, filter }">
        <div class="full-width row flex-center text-accent q-gutter-sm">
          <q-icon size="2em" name="sentiment_dissatisfied"/>
          <span>
            Well this is sad... {{ message }}
          </span>
          <q-icon size="2em" :name="search ? 'filter_b_and_w' : icon"/>
        </div>
      </template>

    </q-table>

  </div>
</template>

<script>
    import bus from '../../../utils/bus.js'
    import {QSpinnerGears, date} from 'quasar'

    export default {
        name: "RolesList",
        data() {
            return {
                roles: [],
                loading: true,
                search: '',

                visibleColumns: ['id', 'name', 'description'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left'},
                    {name: 'name', align: 'left', label: 'Name', field: 'name'},
                    {name: 'description', align: 'left', label: 'Description', field: 'description'},
                ],
            }
        },
        created() {
            this.getRoles()
        },
        mounted() {
            // bus.$on('refreshActivityLogs', () => {
            //     this.getActivityLogs()
            // })
        },
        watch: {
        },
        methods: {
            getRoles() {
                this.loading = true
                this.$axios.get('/api/admin/roles')
                    .then(response => {
                        console.log(response)
                        this.roles = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error)
                        this.loading = false
                    })
            },
        },
    }
</script>

<style scoped lang="scss">
  .listScrollable {
    max-height: 15vh;
    /*width: 350px;*/
    flex-grow: 3;
    overflow-y: auto;
  }
  .userInformations {
    flex-grow: 1;
  }
</style>

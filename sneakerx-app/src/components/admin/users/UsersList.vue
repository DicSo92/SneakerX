<template>
  <div class="q-pa-md">
    <q-table
      title="Treats"
      :data="users"
      :columns="columns"
      row-key="name"
      selection="single"
      :selected.sync="selected"
      :visible-columns="visibleColumns"
    >

      <template v-slot:top>
        <img
          style="height: 50px; width: 50px"
          src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg"
        >

        <q-space />

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
    </q-table>
  </div>
</template>

<script>
    export default {
        name: "UsersList",
        props: [
            'users'
        ],
        data() {
            return {
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
                    {name: 'email_verified_at', label: 'Verified At', field: 'email_verified_at'},
                    {name: 'is_admin', label: 'Admin', field: 'is_admin'},
                    {name: 'created_at', label: 'Created At', field: 'created_at'},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                ],
            }
        }
    }
</script>

<style scoped>

</style>

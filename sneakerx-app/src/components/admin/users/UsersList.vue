<template>
  <div class="q-pa-md">
    <q-table
      title="Treats"
      :data="users"
      :columns="columns"
      row-key="name"
      selection="single"
      :selected.sync="selected"
    />
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
                    {name: 'created_at', label: 'Created', field: 'created_at'},
                    {name: 'updated_at', label: 'Updated', field: 'updated_at', sortable: true},
                ],
            }
        }
    }
</script>

<style scoped>

</style>

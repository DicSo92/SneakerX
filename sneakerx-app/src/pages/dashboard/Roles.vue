<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-grey-10 text-white flex full-width">
        <div class="text-h6">Role / List</div>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <RolesList></RolesList>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
    import RolesList from 'components/admin/roles/RolesList.vue'

    export default {
        name: "Roles",
        components: {
            RolesList,
        },
        data() {
            return {

            }
        },
        created() {

        },
        mounted() {
        },
        computed: {},
        methods: {

        }
    }
</script>

<style scoped>

</style>

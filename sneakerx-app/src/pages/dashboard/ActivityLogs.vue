<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-teal text-white flex full-width">
        <div class="text-h6">Logs / List</div>
        <q-space/>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <LogsList @selectedChange="changeSelect"></LogsList>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
    import LogsList from 'components/admin/activityLogs/LogsList.vue'

    export default {
        name: "ActivityLogs",
        components: {
            LogsList,
        },
        data() {
            return {
                selected: []
            }
        },
        created() {

        },
        mounted() {
        },
        computed: {},
        methods: {
            changeSelect(selected) {
                this.selected = selected
            },
        }
    }
</script>

<style scoped>

</style>

<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-grey-10 text-white flex full-width">
        <div class="text-h6">News / List</div>
        <q-space/>
        <div class="flex">
          <q-btn class="q-mr-sm"
                 color="white"
                 outline
                 icon="edit"
                 label="Edit"
                 :disable="selected.length !== 1"
                 @click="editActuality"
          />
          <q-btn class="q-mr-sm"
                 color="purple-9"
                 icon="add"
                 label="Add"
                 @click="addActuality"
          />
          <q-btn color="red-10"
                 icon="delete"
                 label="Delete Selection"
                 :disable="!selected.length"
                 @click="deleteNews"
          />
        </div>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <NewsList @selectedChange="changeSelect"></NewsList>
      </q-card-section>
    </q-card>
    <AddModal></AddModal>
    <EditModal></EditModal>
  </q-page>
</template>

<script>
    import NewsList from 'components/admin/news/NewsList.vue'
    import AddModal from 'components/admin/news/AddModal.vue'
    import EditModal from 'components/admin/news/EditModal.vue'

    export default {
        name: "News",
        components: {
            NewsList,
            AddModal,
            EditModal
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
            addActuality() {
                this.$root.$emit('showAddActuality', true)
            },
            editActuality() {
                this.$root.$emit('showEditActuality', true, this.selected[0])
            },
            deleteNews() {
                this.$root.$emit('deleteActuality', this.selected)
            },
        }
    }
</script>

<style scoped>

</style>

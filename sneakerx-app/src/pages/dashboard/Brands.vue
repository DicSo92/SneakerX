<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-teal text-white flex full-width">
        <div class="text-h6">Brand / List</div>
        <q-space/>
        <div class="flex">
          <q-btn class="q-mr-sm"
                 color="primary"
                 icon="edit"
                 label="Edit"
                 :disable="!selected.length"
                 @click="editBrand"
          />
          <q-btn class="q-mr-sm"
                 color="positive"
                 icon="add"
                 label="Add"
                 @click="addBrand"
          />
          <q-btn color="negative"
                 icon="delete"
                 label="Delete"
                 :disable="!selected.length"
                 @click="deleteBrand"
          />
        </div>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <BrandsList @selectedChange="changeSelect"></BrandsList>
      </q-card-section>
    </q-card>
    <AddModal></AddModal>
    <EditModal></EditModal>
  </q-page>
</template>

<script>
    import BrandsList from 'components/admin/brands/BrandsList.vue'
    import AddModal from 'components/admin/brands/AddModal.vue'
    import EditModal from 'components/admin/brands/EditModal.vue'

    export default {
        name: "Brands",
        components: {
            BrandsList,
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
            addBrand() {
                this.$root.$emit('showAddBrand', true)
            },
            editBrand() {
                this.$root.$emit('showEditBrand', true, this.selected[0])
            },
            deleteBrand() {
                this.$root.$emit('deleteBrand', this.selected[0].id)
            },
        }
    }
</script>

<style scoped>

</style>

<template>
  <q-page class="column items-center">
    <h3>Brands</h3>
    <BrandsList></BrandsList>
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
        data () {
            return {

            }
        },
        created() {

        },
        mounted() {
        },
        computed: {

        },
        methods: {

        }
    }
</script>

<style scoped>

</style>

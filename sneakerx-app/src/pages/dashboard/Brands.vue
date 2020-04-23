<template>
  <q-page class="column items-center">
    <h3>Brands</h3>
    <AddBrand></AddBrand>
    <BrandsList></BrandsList>
    <AddModal></AddModal>
  </q-page>
</template>

<script>
    import AddBrand from 'components/admin/brands/AddBrand.vue'
    import BrandsList from 'components/admin/brands/BrandsList.vue'
    import AddModal from 'components/admin/brands/AddModal.vue'

    export default {
        name: "Brands",
        components: {
            AddBrand,
            BrandsList,
            AddModal
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

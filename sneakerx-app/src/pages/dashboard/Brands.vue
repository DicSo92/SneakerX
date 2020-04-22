<template>
  <q-page class="column items-center">
    <h3>Brands</h3>
    <AddBrand></AddBrand>
    <BrandList></BrandList>
  </q-page>
</template>

<script>
    import AddBrand from 'components/admin/brands/AddBrand.vue'
    import BrandList from 'components/admin/brands/BrandsList.vue'

    export default {
        name: "Brands",
        components: {
            AddBrand,
            BrandList
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

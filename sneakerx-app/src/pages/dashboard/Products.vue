<template>
  <q-page class="column flex-center">
    <h3>Products</h3>
    <ProductsList></ProductsList>
  </q-page>
</template>

<script>
    import ProductsList from 'components/admin/products/ProductsList.vue'

    export default {
        name: "Products",
        components: {
            ProductsList
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

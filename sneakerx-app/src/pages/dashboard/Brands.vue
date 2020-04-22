<template>
  <q-page class="column items-center">
    <h3>Brands</h3>
    <AddBrand></AddBrand>
  </q-page>
</template>

<script>
    import AddBrand from 'components/admin/brands/AddBrand.vue'

    export default {
        name: "Brands",
        components: {
            AddBrand
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

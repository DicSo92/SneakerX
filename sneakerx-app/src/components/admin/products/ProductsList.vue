<template>

</template>

<script>
    export default {
        name: "ProductsList",
        components: {
        },
        data () {
            return {
                loading: false,
                products: null
            }
        },
        created() {
            this.getProducts()
        },
        mounted() {
        },
        computed: {
        },
        methods: {
            getProducts() {
                this.loading = true
                this.$axios.get('/api/admin/products')
                    .then(response => {
                        console.log(response)
                        this.products = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log('error')
                        console.log(error)
                        this.loading = false
                    })
            },
        }
    }
</script>

<style scoped>

</style>

<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row full-width borderBottom q-mb-md">
      <h6 class="no-margin ">Product :</h6>
    </div>

    <ProductShow v-if="product" :product="product"></ProductShow>
  </q-page>
</template>

<script>
    import ProductShow from '../../components/client/product/ProductShow.vue'

    export default {
        name: "Product",
        components: {
            ProductShow
        },
        data() {
            return {
                product: null,
                loading: false
            }
        },
        created() {
            this.getProduct(this.$route.params.slug)
        },
        methods: {
            getProduct(slug) {
                this.loading = true
                this.$axios.get(`/api/client/products/${slug}`)
                    .then(response => {
                        console.log(response)
                        this.product = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped lang="scss">
  .borderBottom {
    border-bottom: 1px #eeeeee solid;
  }
</style>

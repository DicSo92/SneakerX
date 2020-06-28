<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center full-width">
      <div class="col-10">
        <div class="row full-width borderBottom q-mb-md">
          <h6 class="no-margin ">Search :</h6>
        </div>

        <div class="text-center" v-if="!loading && (!searchProducts || !searchProducts.length)">
          <div class="text-h1 text-weight-bolder text-grey-5">
            No Result !
          </div>
          <div class="text-h6 text-weight-bolder text-grey-6">
            Please try to search an other product.
          </div>
        </div>

        <transition
          :duration="300"
          mode="out-in"
          enter-active-class="animated fadeIn"
          leave-active-class="animated fadeOut">
          <div class="row q-col-gutter-md justify-start items-start q-mb-md" v-if="!loading">
            <div class="col-3"
                 v-for="product in searchProducts"
                 :key="product.id">

              <CardProduct :product="product"/>

            </div>
          </div>
        </transition>

        <transition
          :duration="300"
          mode="out-in"
          enter-active-class="animated fadeIn"
          leave-active-class="animated fadeOut">
          <div class="row q-col-gutter-md full-width q-mb-md" v-if="loading">
            <div class="col-3"
                 v-for="key in 8"
                 :key="key">

              <CardProductSkeleton/>

            </div>
          </div>
        </transition>
      </div>
    </div>

  </q-page>
</template>

<script>
    import CardProduct from '../../components/client/CardProduct.vue'
    import CardProductSkeleton from '../../components/client/CardProductSkeleton.vue'

    export default {
        name: "Search",
        components: {
            CardProduct,
            CardProductSkeleton
        },
        data() {
            return {
                searchProducts: null,
                totalProducts: null,

                loading: false
            }
        },
        created() {
            this.getSearch(this.$route.query.search)
        },
        beforeRouteUpdate (to, from, next) {
            // Prevent routing problem
            this.getSearch(to.query.search)
            next()
        },
        methods: {
            getSearch(search) {
                if (search) {
                    this.loading = true

                    this.$axios.get(`/api/client/products/search/${search}`)
                        .then(response => {
                            console.log(response)
                            this.searchProducts = response.data
                            this.totalProducts = response.data.length

                            this.loading = false
                        })
                        .catch(error => {
                            console.log(error)
                            this.searchProducts = null
                        })
                }
            },
            goToProduct(slug) {
                console.log('go to');
                this.$router.push({name: 'product', params: {slug: slug}})
                this.$emit('toggleDisplaySearchBar')
                this.$refs.searchbar.value = ''
                this.searchProducts = null
            },
        }
    }
</script>

<style scoped>

</style>

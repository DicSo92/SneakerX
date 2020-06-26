<template>
  <div class="q-pa-md">
    <div class="row justify-center q-pa-md">
      <div class="text-h6" style="text-decoration: underline">
        NEW PRODUCTS
      </div>
    </div>
    <transition
      :duration="300"
      mode="out-in"
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut">
      <div class="row justify-start items-start q-col-gutter-lg no-wrap-sm" v-if="!loading">
        <div class="col-xs-12 col-sm"
             v-for="product in responsiveProducts"
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
      <div class="row justify-start items-start q-col-gutter-lg no-wrap-sm" v-if="loading">
        <div class="col-xs-12 col-sm"
             v-for="product in responsiveProductsSkeleton"
             :key="product">

          <CardProductSkeleton/>

        </div>
      </div>

    </transition>
    <div class="row justify-end q-mt-md">
      <q-btn outline color="black" label="VIEW ALL" icon-right="chevron_right" @click="goTo('catalog')"/>
    </div>
  </div>
</template>

<script>
    import CardProduct from '../CardProduct.vue'
    import CardProductSkeleton from '../CardProductSkeleton.vue'


    export default {
        name: "NewProducts",
        components: {
            CardProduct,
            CardProductSkeleton
        },
        data() {
            return {
                products: [],
                loading: true
            }
        },
        filters: {
            truncate: function (text, length, suffix) {
                if (text.length > length) {
                    return text.substring(0, length) + suffix;
                } else {
                    return text;
                }
            },
        },
        mounted() {
            this.getProducts()
        },
        computed: {
            responsiveProducts() {
                if (this.$q.screen.lg || this.$q.screen.xl) {
                    return this.products
                } else if (this.$q.screen.md) {
                    return this.products.slice(0, 4)
                } else if (this.$q.screen.sm) {
                    return this.products.slice(0, 3)
                } else {
                    return this.products.slice(0, 2)
                }
            },
            responsiveProductsSkeleton() {
                if (this.$q.screen.lg || this.$q.screen.xl) {
                    return 5
                } else if (this.$q.screen.md) {
                    return 4
                } else if (this.$q.screen.sm) {
                    return 3
                } else {
                    return 2
                }
            },
        },
        methods: {
            getProducts() {
                this.loading = true

                this.$axios.get(`/api/client/products?page=1&nb=5`)
                    .then(response => {
                        console.log(response)
                        this.products = response.data.data
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
            goTo(route) {
                this.$router.push({name: route})
            }
        },
    }
</script>

<style scoped lang="scss">

</style>

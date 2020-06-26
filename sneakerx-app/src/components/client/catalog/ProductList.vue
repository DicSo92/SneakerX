<template>
  <div class="column items-center full-width">
    <div class="flex full-width justify-between items-center q-mb-sm">
      <p class="no-margin" v-if="totalProducts">
        Total Products : {{totalProducts}}
      </p>
      <div class="flex">
        <q-select v-model="nbPerPage"
                  :options="selectNbPerPage"
                  label="Per Page"
                  style="min-width: 80px" dense
        />
        <q-pagination v-if="maxPages"
                      v-model="page"
                      color="black"
                      :max="maxPages"
                      :input="true">
        </q-pagination>
      </div>
    </div>
    <transition
      :duration="300"
      mode="out-in"
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut">
      <div class="row q-col-gutter-md justify-start items-start q-mb-md" v-if="!loading">
        <div class="col-3"
             v-for="product in products"
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
             v-for="key in nbPerPage"
             :key="key">

          <CardProductSkeleton/>

        </div>
      </div>
    </transition>
    <div class="flex flex-center q-mb-md">
      <q-pagination
        v-if="!loading"
        v-model="page"
        :max="maxPages"
        color="black"
        :direction-links="true"
        :boundary-links="true"
        icon-first="skip_previous"
        icon-last="skip_next"
        icon-prev="fast_rewind"
        icon-next="fast_forward"
      >
      </q-pagination>
    </div>
  </div>

</template>

<script>
    import CardProduct from '../CardProduct.vue'
    import CardProductSkeleton from '../CardProductSkeleton.vue'

    export default {
        name: "ProductList",
        components: {
            CardProduct,
            CardProductSkeleton
        },
        data() {
            return {
                products: null,

                page: 1,
                nbPerPage: 8,
                maxPages: null,
                totalProducts: null,

                selectNbPerPage: [4, 8, 12, 16, 20],
                loading: true
            }
        },
        created() {
            this.getProducts(this.page, this.nbPerPage)
        },
        watch: {
            nbPerPage(val) {
                this.getProducts(this.page, val)
            },
            page(val) {
                this.getProducts(val, this.nbPerPage)
            }
        },
        computed: {},
        methods: {
            getProducts(page, nb) {
                this.loading = true
                this.$axios.get(`/api/client/products?page=${page}&nb=${nb}`)
                    .then(response => {
                        console.log(response)
                        this.products = response.data.data
                        this.maxPages = response.data.last_page
                        this.totalProducts = response.data.total
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>

<style scoped>

</style>

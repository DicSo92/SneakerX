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
      <div class="row q-col-gutter-md full-width q-mb-md" v-if="!loading">
        <div class="col-3"
             v-for="product in products"
             :key="product.id">
          <q-card class="column justify-between full-height">
            <q-img @click="goToProduct(product.slug)"
                   class="cursor-pointer"
                   :src="product.image"
                   style="width: 100%; height: auto"
                   basic>
              <div class="absolute-bottom text-h6">
                {{product.name}}
              </div>
            </q-img>

            <q-card-section>
              {{product.description}}
            </q-card-section>

            <q-card-actions style="border-top: 1px solid #eeeeee;">
              <q-btn flat>
                {{ product.price / 100 }} €
              </q-btn>
              <q-space/>
              <q-btn outline icon="shopping_cart" color="primary" @click.stop="addToCart(product)">
                Add Cart
              </q-btn>
            </q-card-actions>
          </q-card>
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
          <q-card>
            <q-skeleton width="100%" height="200px" square/>
            <q-card-section>
              <q-skeleton type="text"/>
              <q-skeleton type="text"/>
              <q-skeleton type="text"/>
              <q-skeleton type="text"/>
            </q-card-section>

            <q-card-actions align="right" class="q-gutter-md">
              <q-skeleton type="QBtn"/>
              <q-skeleton type="QBtn"/>
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </transition>
    <div class="flex flex-center q-mb-md">
      <q-pagination
        v-if="!loading"
        v-model="page"
        :max="maxPages"
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
    export default {
        name: "ProductList",
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
            goToProduct(slug) {
                console.log('go to');
                this.$router.push({name: 'product', params: {slug: slug}})
            },
            addToCart(product) {
                console.log(product)
                this.$store.dispatch('cart/updateStorageCart', {product, color: product.colors[0], size: product.sizes[0].size, total: 1})
            },
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

<template>
  <q-page class="column items-center" padding>
    <div class="full-width q-mb-md">
      <h5 class="no-margin">Products</h5>
      <q-separator/>
    </div>

    <q-card class="full-width">
      <q-card-section class="bg-teal text-white">
        <div class="text-h6">Product / List</div>
<!--        <div class="text-subtitle2">by John Doe</div>-->
      </q-card-section>

      <q-separator/>

      <q-tabs v-model="tab" class="text-teal">
        <q-tab label="All Products" name="one" />
        <q-tab v-for="brand in brands" :label="brand.name" :name="brand.name" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="one">
          <ProductsList></ProductsList>
        </q-tab-panel>

        <q-tab-panel v-for="brand in brands" :name="brand.name">
          With so much content to display at once, and often so little screen real-estate,
          Cards have fast become the design pattern of choice for many companies, including
          the likes of Google and Twitter.
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
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
                loadingBrands: false,
                tab: 'one',
                brands: null
            }
        },
        created() {
            this.getBrands()
        },
        mounted() {
        },
        computed: {
        },
        methods: {
            getBrands() {
                this.loadingBrands = true
                this.$axios.get('/api/admin/brands')
                    .then(response => {
                        console.log(response)
                        this.brands = response.data
                        this.loadingBrands = false
                    })
                    .catch(error => {
                        console.log('error')
                        console.log(error)
                        this.loadingBrands = false
                    })
            },
        }
    }
</script>

<style scoped lang="scss">
    .Products {

    }
</style>

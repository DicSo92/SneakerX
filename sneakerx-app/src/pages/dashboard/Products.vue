<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-grey-10 text-white flex full-width">
        <div class="text-h6">Product / List</div>
<!--        <div class="text-subtitle2">by John Doe</div>-->
        <q-space/>
        <div class="flex">
          <q-btn class="q-mr-sm"
                 color="white"
                 outline
                 icon="edit"
                 label="Edit"
                 disable
          />
          <q-btn class="q-mr-sm"
                 color="purple-9"
                 icon="add"
                 label="Add"
                 @click="addProduct"
          />
          <q-btn color="red-10"
                 icon="delete"
                 label="Delete Selection"
                 disable
          />
        </div>
      </q-card-section>

      <q-separator/>

      <q-tabs v-model="tab" class="text-purple-9">
        <q-tab label="All" name="All" />
        <q-tab v-for="brand in brands" :label="brand.name" :key="brand.id" :name="brand.id" />
      </q-tabs>

      <q-separator />

      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="All">
          <ProductsList :brands="brands" :brandSelected="tab"></ProductsList>
        </q-tab-panel>

        <q-tab-panel v-for="brand in brands" :key="brand.id" :name="brand.id">
          <ProductsList :brands="brands" :brandSelected="tab"></ProductsList>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
    <AddModal :brands="brands"></AddModal>
  </q-page>
</template>

<script>
    import ProductsList from 'components/admin/products/ProductsList.vue'
    import AddModal from 'components/admin/products/AddModal.vue'


    export default {
        name: "Products",
        components: {
            ProductsList,
            AddModal
        },
        data () {
            return {
                loadingBrands: false,
                tab: 'All',
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
            addProduct() {
                this.$root.$emit('showAddProduct', true)
            },
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

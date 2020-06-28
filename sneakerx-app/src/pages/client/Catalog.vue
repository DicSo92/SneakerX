<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center">
      <div class="col-10">
        <div class="row q-pb-lg" v-if="brandBanner">
          <q-img :src="brandBanner" class=""></q-img>
        </div>

        <div class="row full-width borderBottom q-mb-md">
          <h6 class="no-margin ">Catalog :</h6>
        </div>

        <ProductList @changeBrandBanner="brandBanner = $event"></ProductList>
      </div>
    </div>

  </q-page>
</template>

<script>
    import ProductList from '../../components/client/catalog/ProductList.vue'

    export default {
        name: 'PageIndex',
        components: {
            ProductList
        },
        data() {
            return {
                brandBanner: null
            }
        },
        methods: {
        }
    }
</script>

<style scoped lang="scss">
  .borderBottom {
    border-bottom: 1px #eeeeee solid;
  }
</style>

<template>
  <div class="brandList column flex-center">
    <q-spinner color="primary"
               size="3em"
               v-if="loading"
    />
    <q-list bordered>
      <q-item clickable v-ripple v-for="brand in brands">
        <q-item-section avatar>
          <q-avatar rounded>
            <img src="https://cdn.quasar.dev/img/mountains.jpg">
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>{{brand.name}}</q-item-label>
          <q-item-label caption lines="2">{{brand.description}}</q-item-label>
        </q-item-section>

        <q-item-section top thumbnail class="q-ml-none">
          <img src="https://cdn.quasar.dev/img/mountains.jpg">
        </q-item-section>

        <q-item-section avatar>
          <q-icon color="negative" name="delete" />
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script>
    export default {
        name: "BrandsList",
        data () {
            return {
                brands: {},
                loading: true
            }
        },
        created () {
            this.getBrands()
        },
         methods: {
             getBrands () {
                 this.loading = true
                 this.$axios.get('/api/admin/brands')
                     .then(response => {
                         console.log(response)
                         this.brands = response.data
                         this.loading = false
                     })
                     .catch(error => {
                         console.log('error')
                         console.log(error)
                         this.loading = false
                     })
             }
         }
    }
</script>

<style scoped>

</style>

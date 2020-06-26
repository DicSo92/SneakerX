<template>
  <q-tabs class="bg-purple-9 text-white shadow-2" >
    <q-route-tab :to="{name: 'catalog'}" exact label="Catalog" />

    <q-btn-dropdown auto-close
                    stretch flat
                    label="Brands">
      <q-list>
        <q-item clickable @click="goBrand(brand)" v-for="brand in brands">
          <q-item-section>{{brand.name}}</q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
<!--    <q-route-tab :to="{name: 'catalog', query: {filter: 'soon'}}" exact label="UpComing" />-->
<!--    <q-route-tab :to="{name: 'catalog', query: {filter: 'latest'}}" exact label="New" />-->
    <q-route-tab :to="{name: 'news'}" exact label="News" />
    <q-route-tab :to="{name: 'contact'}" exact label="Contact" />
<!--    <q-route-tab :to="{name: 'news'}" exact label="News" />-->
<!--    <q-route-tab :to="{name: 'contact'}" exact label="Contact" />-->
  </q-tabs>
</template>

<script>
    export default {
        name: "Tabs",
        data() {
            return {
                brands: [],
                loading: true
            }
        },
        created() {
            this.getBrands()
        },
        methods: {
            getBrands() {
                this.loading = true
                this.$axios.get('/api/admin/brands')
                    .then(response => {
                        console.log(response)
                        this.brands = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error)
                        this.loading = false
                    })
            },
            goBrand(brand) {
                this.$router.push({name: 'catalog', query: {brand: brand.name}})
            }
        }
    }
</script>

<style scoped>

</style>

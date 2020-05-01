<template>
  <div class="brandList column flex-center">

    <div class="full-width flex justify-between q-mb-sm">
      <div id="spinnerContainer">
        <q-spinner color="primary"
                   size="3em"
                   v-if="loading"/>
      </div>
      <q-btn label="New Brand" @click="addBrand" color="primary"/>
    </div>

    <q-list bordered id="list">
      <q-item clickable v-ripple
              v-for="brand in brands"
              :key="brand.id">
        <q-item-section avatar>
          <q-avatar rounded>
            <img :src="brand.image ? brand.image : 'statics/no-image.jpg'">
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>{{brand.name}}</q-item-label>
          <q-item-label caption lines="2" :class="!brand.description ? 'text-red-5' : ''">{{brand.description ? brand.description : 'No description'}}</q-item-label>
        </q-item-section>

        <q-item-section top thumbnail class="q-ml-none">
          <img :src="brand.banner ? brand.banner : 'statics/no-image.jpg'">
        </q-item-section>

        <q-item-section avatar>
          <q-btn outline round color="indigo-12" size='sm' icon="edit" @click="editBrand(brand)" />
        </q-item-section>
        <q-item-section avatar>
          <q-btn outline round color="red-8" size='sm' icon="delete" @click="deleteBrand(brand.id)" />
        </q-item-section>
      </q-item>
    </q-list>

  </div>
</template>

<script>
    import bus from '../../../utils/bus.js'
    import {QSpinnerGears} from 'quasar'

    export default {
        name: "BrandsList",
        data() {
            return {
                brands: {},
                loading: true
            }
        },
        created() {
            this.getBrands()
        },
        mounted() {
            bus.$on('refreshBrands', () => {
                this.getBrands()
            })
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
                        console.log('error')
                        console.log(error)
                        this.loading = false
                    })
            },
            deleteBrand(id) {
                this.$q.loading.show({
                    message: `Deleting Brand...`
                })
                this.$axios.delete(`/api/admin/brands/${id}`)
                    .then(response => {
                        console.log(response)
                        this.brands.splice(this.brands.findIndex(brand => brand.id === id), 1)
                        this.hideLoading('Brand Deleted')
                    })
                    .catch(error => {
                        console.log(error)
                        this.hideLoading('An error occurred : ' + error.message)
                    })
            },
            addBrand() {
                bus.$emit('showAddModalBrand', true)
            },
            editBrand(brand) {
                bus.$emit('showEditModalBrand', true, brand)
            },
            hideLoading(message) {
                this.$q.loading.show({
                    spinner: QSpinnerGears,
                    spinnerColor: 'red',
                    messageColor: 'black',
                    backgroundColor: 'yellow',
                    message: message
                })

                this.timer = setTimeout(() => {
                    this.$q.loading.hide()
                    this.timer = void 0
                }, 2000)
            },
        }
    }
</script>

<style scoped lang="scss">
  #spinnerContainer {
    min-width: 10px;
  }

  #list {
    width: 700px;
    max-width: 80vw;
  }
</style>

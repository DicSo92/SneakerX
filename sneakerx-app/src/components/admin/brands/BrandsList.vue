<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="brands"
      :columns="columns"
      :visible-columns="visibleColumns"
      row-key="name"
      selection="single"
      :selected.sync="selected"
      :loading="loading"
      class="BrandTable"
    >

      <template v-slot:top>
        <q-icon name="group" size="lg"/>

        <q-space/>

        <q-input borderless dense debounce="300" v-model="search" placeholder="Search" class="q-mr-md">
          <q-icon slot="append" name="search"/>
        </q-input>

        <q-select
          v-model="visibleColumns"
          multiple
          outlined
          dense
          options-dense
          :display-value="$q.lang.table.columns"
          emit-value
          map-options
          :options="columns"
          option-value="name"
          options-cover
          style="min-width: 150px"
        />
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th auto-width></q-th>
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            class="text-italic text-purple"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td>
            <q-checkbox v-model="props.selected"/>
          </q-td>
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="image" :props="props" class="columnImage" auto-width>
            <img :src="props.row.image ? props.row.image : 'statics/no-image.jpg'" class="image" alt="">
          </q-td>
          <q-td key="name" :props="props">
            <div class="text-pre-wrap text-bold">{{ props.row.name }}</div>
          </q-td>
          <q-td key="created_at" :props="props" class="text-caption text-grey-7">{{ cFormatDate(props.row.created_at)
            }}
          </q-td>
          <q-td key="updated_at" :props="props" class="text-caption text-grey-7">{{ cFormatDate(props.row.updated_at)
            }}
          </q-td>
          <q-td key="banner" :props="props" auto-width>
            <div class="flex justify-end items-center">
              <img :src="props.row.banner ? props.row.banner : 'statics/no-image.jpg'" class="banner" alt="">
            </div>
          </q-td>
        </q-tr>
      </template>

      <template v-slot:no-data="{ icon, message, filter }">
        <div class="full-width row flex-center text-accent q-gutter-sm">
          <q-icon size="2em" name="sentiment_dissatisfied"/>
          <span>
            Well this is sad... {{ message }}
          </span>
          <q-icon size="2em" :name="search ? 'filter_b_and_w' : icon"/>
        </div>
      </template>

    </q-table>

    <!--    <div class="full-width flex justify-between q-mb-sm">-->
    <!--      <div id="spinnerContainer">-->
    <!--        <q-spinner color="primary"-->
    <!--                   size="3em"-->
    <!--                   v-if="loading"/>-->
    <!--      </div>-->
    <!--      <q-btn label="New Brand" @click="addBrand" color="primary"/>-->
    <!--    </div>-->

    <!--    <q-list bordered id="list">-->
    <!--      <q-item clickable v-ripple-->
    <!--              v-for="brand in brands"-->
    <!--              :key="brand.id">-->
    <!--        <q-item-section avatar>-->
    <!--          <q-avatar rounded>-->
    <!--            <img :src="brand.image ? brand.image : 'statics/no-image.jpg'">-->
    <!--          </q-avatar>-->
    <!--        </q-item-section>-->

    <!--        <q-item-section>-->
    <!--          <q-item-label>{{brand.name}}</q-item-label>-->
    <!--          <q-item-label caption lines="2" :class="!brand.description ? 'text-red-5' : ''">{{brand.description ? brand.description : 'No description'}}</q-item-label>-->
    <!--        </q-item-section>-->

    <!--        <q-item-section top thumbnail class="q-ml-none">-->
    <!--          <img :src="brand.banner ? brand.banner : 'statics/no-image.jpg'">-->
    <!--        </q-item-section>-->

    <!--        <q-item-section avatar>-->
    <!--          <q-btn outline round color="indigo-12" size='sm' icon="edit" @click="editBrand(brand)" />-->
    <!--        </q-item-section>-->
    <!--        <q-item-section avatar>-->
    <!--          <q-btn outline round color="red-8" size='sm' icon="delete" @click="deleteBrand(brand.id)" />-->
    <!--        </q-item-section>-->
    <!--      </q-item>-->
    <!--    </q-list>-->

  </div>
</template>

<script>
    import bus from '../../../utils/bus.js'
    import {QSpinnerGears, date} from 'quasar'

    export default {
        name: "BrandsList",
        data() {
            return {
                brands: [],
                loading: true,
                search: '',

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 6
                    // rowsNumber: xx if getting data from a server
                },
                selected: [],
                visibleColumns: ['id', 'image', 'name', 'banner'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'image', align: 'left', label: 'Image', field: 'image'},
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                    {name: 'banner', label: 'Banner', field: 'banner', align: 'right'},
                ],
            }
        },
        created() {
            this.getBrands()

            this.$root.$on('addBrand', this.addBrand)
            this.$root.$on('deleteBrand', id => {
                this.deleteBrand(id)
            })
            this.$root.$on('editBrand', brand => {
                this.editBrand(brand)
            })
        },
        mounted() {
            bus.$on('refreshBrands', () => {
                this.getBrands()
            })
        },
        watch: {
            selected (val) {
                this.$emit('selectedChange', val)
            },
        },
        methods: {
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
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
        },
        beforeDestroy () {
            // Don't forget to turn the listener off before your component is destroyed
            this.$root.$off('addBrand', this.addBrand)
            this.$root.$off('deleteBrand', id => {
                this.deleteBrand(id)
            })
            this.$root.$off('editBrand', brand => {
                this.editBrand(brand)
            })
        },
    }
</script>

<style scoped lang="scss">
  #spinnerContainer {
    min-width: 10px;
  }

  .BrandTable {
    max-width: 100%;

    td:first-child {
      text-align: center;
    }

    thead tr:first-child th:first-child {
      background-color: #dedede;
    }
    thead tr:last-child th:last-child {
      background-color: #eeeeee;
    }

    td:first-child {
      background-color: #efefef;
    }

    td:first-child, th:first-child {
      position: sticky;
      left: 0;
      z-index: 1;
    }

    td:last-child, th:last-child {
      position: sticky;
      right: 0;
      z-index: 1;
    }
  }

  .image {
    // Combine with auto-width
    max-height: 100%;
    width: auto;
  }

  .banner {
    // Combine with auto-width
    max-height: 90px;
    width: auto;
  }
  @media screen and (max-width: 1439px) {
    .banner {
      // Combine with auto-width
      max-height: 70px;
      width: auto;
    }
  }
  @media screen and (max-width: 1023px) {
    .banner {
      // Combine with auto-width
      max-height: 50px;
      width: auto;
    }
  }
</style>

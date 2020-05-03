<template>
  <div class="full-width" id="productList">
    <q-table
      title="Treats"
      :data="products"
      :columns="columns"
      row-key="id"
      selection="multiple"
      :selected.sync="selected"
      :visible-columns="visibleColumns"
      :loading="loading"
      :pagination.sync="pagination"
      class="my-sticky-column-table"
      v-if="showTable">


      <template v-slot:top>
        <q-icon name="list" size="lg"/>

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
          <q-th auto-width>
            <q-checkbox v-model="props.selected"/>
          </q-th>
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            auto-width
            class="text-italic text-purple"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props" @click="props.expand = !props.expand" class="cursor-pointer">
          <q-td auto-width>
            <q-checkbox v-model="props.selected"/>
          </q-td>
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="image" :props="props" auto-width>
            <q-avatar rounded>
              <img :src="props.row.image">
            </q-avatar>
          </q-td>
          <q-td key="name" :props="props" class="columnName text-bold" auto-width>
            {{ props.row.name }}
          </q-td>
          <q-td key="slug" :props="props" auto-width>
            {{ props.row.slug }}
          </q-td>
          <q-td key="description" :props="props">
            <div class="columnDescription">
              {{ props.row.description }}
            </div>
          </q-td>
          <q-td key="price" :props="props" auto-width>
            {{ props.row.price / 100 }} €
          </q-td>

          <q-td key="brand_id" :props="props" auto-width>
            <q-btn outline rounded size="sm" color="primary" :label="getBrandName(props.row.brand_id)" >
              <q-badge floating transparent color="amber">
                {{ props.row.brand_id }}
              </q-badge>
            </q-btn>
          </q-td>
          <q-td key="colors" :props="props" class="columnColors" auto-width>
            <div class="flex">
              <div v-for="color in props.row.colors" class="squareColor q-mr-sm q-my-xs" :style="{background: color.color}"></div>
            </div>
          </q-td>
          <q-td key="sizes" :props="props" class="columnSizes" auto-width>
            <div class="flex">
              <q-badge outline color="secondary" text-color="black"
                       v-for="size in props.row.sizes"
                       :key="size.size"
                       :label="size.size"
                       class="q-mr-sm q-my-xs" />
            </div>
          </q-td>
          <q-td key="refLink" :props="props" auto-width>
            <q-btn outline size="sm" rounded color="primary" label="Official Page" @click="openExternalLink(props.row.refLink)"/>
          </q-td>
          <q-td key="created_at" :props="props" auto-width>{{ cFormatDate(props.row.created_at) }}</q-td>
          <q-td key="updated_at" :props="props" auto-width>{{ cFormatDate(props.row.updated_at) }}</q-td>
          <q-td key="active" :props="props" auto-width>
            <q-btn round size="xs" :color="props.row.active === 1 ? 'positive' : 'negative'"
                   :icon="props.row.active === 1 ? 'done' : 'clear'"/>
          </q-td>
        </q-tr>

        <q-tr v-show="props.expand" :props="props">
          <q-td colspan="100%">
            <div class="flex no-wrap">
              <div class="column items-start">
                <p class="text-bold no-margin">Main Image : </p>
                <div class="flex justify-center items-center" style="flex-grow: 3;">
                  <q-avatar rounded size="150px">
                    <img :src="props.row.image">
                  </q-avatar>
                </div>
              </div>
              <q-separator vertical inset class="q-mx-md"/>
              <div class="column items-start">
                <p class="text-bold no-margin">Secondary Images : </p>
                <div class="flex justify-center items-center" style="flex-grow: 3;">
                  <q-avatar rounded size="100px"
                            class="q-ma-xs"
                            v-for="image in props.row.images"
                            :key="image">
                    <img :src="image">
                  </q-avatar>
                </div>
              </div>
              <q-separator vertical inset class="q-mx-md"/>

              <div class="column items-start" style="flex-shrink: 3;">
                <h6 class="text-bold no-margin">{{props.row.name}}</h6>
                <p class="text-overline no-margin">{{getBrandName(props.row.brand_id)}}</p>
                <div class="column">
                  <p class="text-left text-caption text-grey-6 expandDescription">{{props.row.description}}</p>
                  <div class="flex q-mb-xs">
                    <div class="flex q-mr-md">
                      <p class="text-subtitle2 q-mb-none q-mr-sm">Colors :</p>
                      <div v-for="color in props.row.colors"
                           :key="color.color"
                           class="squareColor q-mr-sm q-my-xs"
                           :style="{background: color.color}"></div>
                    </div>
                    <div class="flex">
                      <p class="text-subtitle2 q-mb-none q-mr-sm">Sizes :</p>
                      <q-badge outline color="secondary" text-color="black"
                               v-for="size in props.row.sizes"
                               :key="size.size"
                               :label="size.size"
                               class="q-mr-sm q-my-xs" />
                    </div>
                  </div>
                  <div class="flex">
                    <q-btn flat rounded color="primary" label="Preview" />
                    <q-btn outline rounded color="primary" label="Official Page" @click="openExternalLink(props.row.refLink)"/>
                  </div>
                </div>
              </div>

              <div class="expandBtnContainer relative-position" style="flex-grow: 3;">
                <div class="flex absolute-top-right no-wrap">
                  <q-btn round size="sm" color="primary" icon="edit" class="q-mr-sm"/>
                  <q-btn round size="sm" color="negative" icon="delete" class="q-mr-sm"/>
                </div>
              </div>
            </div>
          </q-td>
        </q-tr>
      </template>

    </q-table>
  </div>
</template>

<script>
    import { date, openURL } from 'quasar'

    export default {
        name: "ProductsList",
        components: {},
        props: [
            'brands'
        ],
        data() {
            return {
                showTable: false,
                loading: false,
                search: '',
                products: [],

                selected: [],
                visibleColumns: ['id', 'image', 'name', 'description', 'price', 'brand_id', 'colors', 'active'],

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 8
                    // rowsNumber: xx if getting data from a server
                },
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'image', label: 'Image', field: 'image', align: 'left', sortable: true},
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'slug', label: 'Slug', field: 'slug', align: 'left', sortable: true},
                    {name: 'description', label: 'Description', field: 'description', align: 'left', sortable: true},
                    // {name: 'images', label: 'Images', field: 'images', sortable: true},
                    {name: 'price', label: 'Price', field: 'price', sortable: true},
                    {name: 'brand_id', label: 'Brand Id', field: 'brand_id', align: 'center', sortable: true},
                    {name: 'colors', label: 'Colors', field: 'colors', align: 'left'},
                    {name: 'sizes', label: 'Sizes', field: 'sizes', align: 'left'},
                    {name: 'refLink', label: 'Ref. Link', field: 'refLink', align: 'left'},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                    {
                        name: 'active',
                        label: 'Active',
                        field: 'active',
                        align: 'center',
                        sortable: true,
                        required: true,
                    },
                ],
            }
        },
        created() {
            this.getProducts()
        },
        mounted() {
            this.showTable = true
        },
        computed: {},
        methods: {
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
            getBrandName(id) {
                return this.brands.find(brand => brand.id === id).name
            },
            openExternalLink(link) {
                openURL(link)
            },
            getProducts() {
                this.loading = true
                this.$axios.get('/api/admin/products')
                    .then(response => {
                        console.log(response)
                        this.products = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log('error')
                        console.log(error)
                        this.loading = false
                    })
            },
        }
    }
</script>

<style scoped lang="scss">
  #productList {

  }
  .expandDescription {
    white-space: normal;
    display: -webkit-box;
    -webkit-line-clamp: 8;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .columnDescription {
    font-size: 0.85em;
    font-style: italic;
    max-width: 200px;
    white-space: normal;

    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .columnName {
    text-overflow: ellipsis;
    max-width: 200px;
    /* Needed to make it work */
    overflow: hidden;
    white-space: nowrap;
  }
  .columnColors {
    min-width: 80px;
    /* Needed to make it work */
    overflow: hidden;
    white-space: nowrap;
  }
  .columnSizes {
    min-width: 140px;
    /* Needed to make it work */
    overflow: hidden;
    white-space: nowrap;
  }

  .my-sticky-column-table {
    max-width: 100%;

    td:first-child {
      text-align: center;
    }

    thead tr:first-child th:first-child, tr:last-child th:last-child {
      background-color: #dedede;
    }

    td:first-child, td:last-child {
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


  .expandBtnContainer {
    width: 50px;
    height: 200px;
    /*background-color: #1b5e20;*/
    position: sticky;
    right: 0;
  }
  .squareColor {
    width: 15px;
    height: 15px;
    border: 1px white solid;
    border-radius: 3px;
  }
</style>


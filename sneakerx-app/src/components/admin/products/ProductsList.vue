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
        <q-tr :props="props">
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
          <q-td key="name" :props="props" class="columnName" auto-width>
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
            {{ props.row.price }}
          </q-td>

          <q-td key="brand_id" :props="props" auto-width>
            {{ props.row.brand_id }}
          </q-td>
          <q-td key="refLink" :props="props"class="columnRefLink" auto-width>
            {{ props.row.refLink }}
          </q-td>
          <q-td key="created_at" :props="props" auto-width>{{ cFormatDate(props.row.created_at) }}</q-td>
          <q-td key="updated_at" :props="props" auto-width>{{ cFormatDate(props.row.updated_at) }}</q-td>
          <q-td key="active" :props="props" auto-width>
            {{ props.row.active }}
          </q-td>
        </q-tr>
      </template>

    </q-table>
  </div>
</template>

<script>
    import {QSpinnerFacebook, QSpinnerGears, date} from 'quasar'

    export default {
        name: "ProductsList",
        components: {},
        data() {
            return {
                showTable: false,
                loading: false,
                search: '',
                products: [],

                selected: [],
                visibleColumns: ['id', 'image', 'name', 'description', 'price', 'brand_id', 'refLink', 'active'],

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 6
                    // rowsNumber: xx if getting data from a server
                },
                columns: [
                    {name: 'id', required: true, label: 'ID', align: 'left', sortable: true},
                    {name: 'image', label: 'Image', field: 'image', align: 'left', sortable: true},
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'slug', label: 'Slug', field: 'slug', align: 'left', sortable: true},
                    {name: 'description', label: 'Description', field: 'description', align: 'left', sortable: true},
                    // {name: 'images', label: 'Images', field: 'images', sortable: true},
                    {name: 'price', label: 'Price', field: 'price', sortable: true},
                    {name: 'brand_id', label: 'Brand Id', field: 'brand_id', align: 'center', sortable: true},
                    {name: 'refLink', label: 'Ref. Link', field: 'refLink', align: 'left', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                    {name: 'active', label: 'Active', field: 'active', sortable: true},
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
  .columnRefLink {
    text-overflow: ellipsis;
    max-width: 200px;
    /* Needed to make it work */
    overflow: hidden;
    white-space: nowrap;
  }
  .columnName {
    text-overflow: ellipsis;
    max-width: 250px;
    /* Needed to make it work */
    overflow: hidden;
    white-space: nowrap;
  }

  .my-sticky-column-table {
    max-width: 100%;
    thead tr:first-child th:first-child {
    /* bg color is important for th; just specify one */
    background-color: #fff;
    }
    td:first-child {
      background-color: #efefef;
    }
    th:first-child {
      position: sticky;
      left: 0;
      z-index: 1;
    }
    td:first-child {
      position: sticky;
      left: 0;
      z-index: 1;
    }
  }




</style>


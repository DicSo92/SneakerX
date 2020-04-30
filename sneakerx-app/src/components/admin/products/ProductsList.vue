<template>
  <div class="q-pa-md" id="productList">
    <q-table
      title="Treats"
      :data="products"
      :columns="columns"
      row-key="id"
      :pagination.sync="pagination"
      v-if="showTable"
    />
  </div>
</template>

<script>
    export default {
        name: "ProductsList",
        components: {},
        data() {
            return {
                showTable: false,
                loading: false,
                products: null,

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 6
                    // rowsNumber: xx if getting data from a server
                },
                columns: [
                    {
                        name: 'id', required: true, label: 'ID',
                        field: row => row.id,
                        format: val => `#${val}`,
                        sortable: true
                    },
                    {name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true},
                    {name: 'slug', label: 'Slug', field: 'slug', sortable: true},
                    {name: 'description', label: 'Description', field: 'description', sortable: true},
                    {name: 'image', label: 'Image', field: 'image', sortable: true},
                    // {name: 'images', label: 'Images', field: 'images', sortable: true},
                    {name: 'price', label: 'Price', field: 'price', sortable: true},
                    {name: 'active', label: 'Active', field: 'active', sortable: true},
                    {name: 'brand_id', label: 'Brand Id', field: 'brand_id', sortable: true},
                    {name: 'refLink', label: 'Ref. Link', field: 'refLink', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                ],
            }
        },
        created() {
            this.getProducts()
        },
        mounted() {
        },
        computed: {},
        methods: {
            getProducts() {
                this.loading = true
                this.$axios.get('/api/admin/products')
                    .then(response => {
                        console.log(response)
                        this.products = response.data
                        this.loading = false
                        this.showTable = true

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
    width: 750px;
    max-width: 90vw;
  }
</style>


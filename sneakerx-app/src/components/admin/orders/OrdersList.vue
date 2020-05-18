<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="orders"
      :columns="columns"
      :visible-columns="visibleColumns"
      row-key="id"
      :loading="loading"
      class="BrandTable"
    >

      <template v-slot:top>
        <q-icon name="local_offer" size="lg"/>

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
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="email" :props="props">
            {{props.row.email}}
          </q-td>
          <q-td key="totalPrice" :props="props">
            {{props.row.totalPrice / 100 }} €
          </q-td>
          <q-td key="paymentStatus" :props="props">
            <div>{{props.row.paymentStatus}}</div>
          </q-td>
          <q-td key="orders_products" :props="props">
            <div>x {{props.row.orders_products.reduce((a, b) => a + (b['quantity'] || 0), 0)}}</div>
          </q-td>
          <q-td key="deliveryStatus" :props="props">
            <div>{{props.row.deliveryStatus}}</div>
          </q-td>
          <q-td key="created_at" :props="props" class="text-caption text-grey-7">
            {{ cFormatDate(props.row.created_at) }}
          </q-td>
          <q-td key="updated_at" :props="props" class="text-caption text-grey-7">
            {{ cFormatDate(props.row.updated_at) }}
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

  </div>
</template>

<script>
    import bus from '../../../utils/bus.js'
    import {QSpinnerGears, date} from 'quasar'

    export default {
        name: "OrdersList",
        data() {
            return {
                orders: [],
                loading: true,
                search: '',

                selected: [],
                visibleColumns: ['id', 'email', 'totalPrice', 'paymentStatus', 'orders_products', 'deliveryStatus', 'created_at', 'updated_at'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'email', align: 'left', label: 'Email', field: 'email', sortable: true},
                    {name: 'totalPrice', align: 'left', label: 'Total Price', field: 'totalPrice', sortable: true},
                    {name: 'paymentStatus', label: 'Payment Status', field: 'paymentStatus', sortable: true},
                    {name: 'orders_products', label: 'Products', field: 'orders_products', sortable: true},
                    {name: 'deliveryStatus', required: true, label: 'Delivery Status', field: 'deliveryStatus', align: 'right', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                ],
            }
        },
        created() {
            this.getOrders()
        },
        mounted() {
            // bus.$on('refreshActivityLogs', () => {
            //     this.getActivityLogs()
            // })
        },
        watch: {
        },
        methods: {
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
            getOrders() {
                this.loading = true
                this.$axios.get('/api/admin/orders')
                    .then(response => {
                        console.log(response)
                        this.orders = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error)
                        this.loading = false
                    })
            },
        },
    }
</script>

<style scoped>

</style>

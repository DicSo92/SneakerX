<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="orders"
      :columns="columns"
      :visible-columns="visibleColumns"
      row-key="id"
      :loading="loading"
      :pagination.sync="pagination"
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
        <q-tr :props="props" @click="props.expand = !props.expand" class="cursor-pointer">
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="email" :props="props">
            <div class="text-bold">
              {{props.row.email}}
            </div>
          </q-td>
          <q-td key="totalPrice" :props="props">
            <div class="text-caption">
              {{props.row.totalPrice / 100 }} €
            </div>
          </q-td>
          <q-td key="orders_products" :props="props" auto-width>
            <div class="text-overline">
              x {{getTotalProducts(props.row.orders_products)}}
            </div>
          </q-td>
          <q-td key="created_at" :props="props" class="text-caption text-grey-7">
            {{ cFormatDate(props.row.created_at) }}
          </q-td>
          <q-td key="updated_at" :props="props" class="text-caption text-grey-7">
            {{ cFormatDate(props.row.updated_at) }}
          </q-td>
          <q-td key="paymentStatus" :props="props" auto-width>
            <q-chip :color="props.row.paymentStatus ? 'green-5' : 'orange-5'"
                    text-color="white" size="md"
                    :label="props.row.paymentStatus ? 'OK' : 'Waiting'"/>
          </q-td>
          <q-td key="deliveryStatus" :props="props" auto-width>
            <q-chip :color="props.row.deliveryStatus ? 'green-5' : 'orange-5'"
                    text-color="white" size="md"
                    :label="props.row.deliveryStatus ? 'DELIVER' : 'In Progress'"/>
          </q-td>
        </q-tr>

        <q-tr v-show="props.expand" :props="props">
          <q-td colspan="100%">
            <div class="flex no-wrap q-gutter-sm">
              <div class="column userInformations">
                <div class="text-overline" >
                  User Informations :
                </div>
                <div class="q-pl-sm">
                  <div class="text-caption text-bold text-red" v-if="!props.row.user">
                    User without an account
                  </div>
                  <div class="text-caption q-pb-sm">
                    <span class="text-bold">Order Email : </span>
                    {{props.row.email}}
                  </div>
                  <div class="q-pb-sm column" v-if="props.row.user">
                    <div class="text-caption">
                      <span class="text-bold">User name : </span>
                      {{props.row.user.name}}
                    </div>
                  </div>
                  <q-btn outline color="primary"
                         label="User Profile"
                         v-if="props.row.user"
                         size="sm" />
                </div>
              </div>

              <q-separator vertical spaced/>

              <div class="column">
                <div class="text-overline">
                  Invoice Informations :
                </div>
                <div class="q-pl-sm column">
                  <div class="text-caption">
                    {{props.row.orders_billing_addresses.firstName + ' ' + props.row.orders_billing_addresses.lastName}}
                  </div>
                  <div class="text-caption">
                    {{props.row.orders_billing_addresses.address + ' - ' + props.row.orders_billing_addresses.postalCode + ', ' + props.row.orders_billing_addresses.city}}
                  </div>
                  <div class="text-caption">
                    {{props.row.orders_billing_addresses.country}}
                  </div>
                  <div class="text-caption">
                    Tel: {{props.row.orders_billing_addresses.phone}}
                  </div>
                </div>
              </div>

              <q-separator vertical spaced/>

              <div class="column">
                <div class="text-overline">
                  Delivery Informations :
                </div>
                <div class="q-pl-sm column">
                  <div class="text-caption">
                    {{props.row.orders_delivery_addresses.firstName + ' ' + props.row.orders_delivery_addresses.lastName}}
                  </div>
                  <div class="text-caption">
                    {{props.row.orders_delivery_addresses.address + ' - ' + props.row.orders_delivery_addresses.postalCode + ', ' + props.row.orders_delivery_addresses.city}}
                  </div>
                  <div class="text-caption">
                    {{props.row.orders_delivery_addresses.country}}
                  </div>
                  <div class="text-caption">
                    Tel: {{props.row.orders_delivery_addresses.phone}}
                  </div>
                </div>
              </div>

              <q-separator vertical spaced/>

              <div class="listScrollable">
                <q-list>
                  <q-item v-for="(product, index) in props.row.orders_products"
                          :key="product.id"
                          class="q-my-sm"
                          clickable
                          dense
                          v-ripple>
                    <q-item-section avatar>
                      <q-avatar rounded>
                        <img :src="product.product.image">
                      </q-avatar>
                    </q-item-section>

                    <q-item-section>
                      <q-item-label lines="1" class="text-bold">
                        <span>x{{product.quantity}} |</span>
                        {{ product.product.name }}
                        <span class="text-caption text-grey-8">- ADIDAS</span>
                      </q-item-label>
                      <q-item-label caption>
                        Color: {{product.color.name}}
                        <span class="q-ml-md">Size: {{product.size}}</span>
                      </q-item-label>
                    </q-item-section>

                    <q-item-section side>
                      <q-item-label caption>
                        {{((product.product.price / 100) * product.quantity).toFixed(2)}} €
                      </q-item-label>
                    </q-item-section>
                  </q-item>
                </q-list>
              </div>
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

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    rowsPerPage: 10
                },

                selected: [],
                visibleColumns: ['id', 'email', 'totalPrice', 'paymentStatus', 'created_at', 'updated_at', 'orders_products', 'deliveryStatus'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'email', align: 'left', label: 'Email', field: 'email', sortable: true},
                    {name: 'totalPrice', align: 'left', label: 'Total Price', field: 'totalPrice', sortable: true},
                    {name: 'orders_products', label: 'Products', field: 'orders_products', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                    {name: 'paymentStatus', label: 'Payment', field: 'paymentStatus', align: 'center', sortable: true},
                    {name: 'deliveryStatus', label: 'Delivery', field: 'deliveryStatus', align: 'center', sortable: true, required: true},
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
            getTotalProducts(orderProduct) {
                return orderProduct.reduce((a, b) => a + (b['quantity'] || 0), 0);
            },
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

<style scoped lang="scss">
  .listScrollable {
    max-height: 15vh;
    /*width: 350px;*/
    flex-grow: 3;
    overflow-y: auto;
  }
  .userInformations {
    flex-grow: 1;
  }
</style>

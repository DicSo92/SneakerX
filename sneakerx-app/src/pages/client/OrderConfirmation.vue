<template>
  <q-page class="flex column justify-start items-center"
          padding
          v-if="orderConfirm">
    <q-banner class="bg-positive text-white text-center full-width q-py-md">
      <div class="text-h6">
        <span class="text-bold">Congratulation !</span> Succesfully Ordered.
      </div>
      <div class="text-caption">
        An Email as been send to :
      </div>
      <div class="text-bold text-overline">{{orderConfirm.email}}</div>
    </q-banner>
    <q-card class="q-mt-md full-width">
      <q-card-section>
        <div class="row">
          <div class="col-sm-7 col-xs-12">
            <div class="column">
              <div class="text-overline">
                Order Summary :
              </div>

              <ProductsTable :orderConfirm="orderConfirm">
              </ProductsTable>

              <q-separator spaced style="min-height: 1px"/>

              <TotalPrice :orderConfirm="orderConfirm">
              </TotalPrice>
            </div>
          </div>
          <q-separator vertical spaced/>
          <div class="col column justify-between">
            <RightPanel :orderConfirm="orderConfirm">

            </RightPanel>
            <ThankYou>

            </ThankYou>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
    import RightPanel from '../../components/client/orderConfirmation/RightPanel.vue'
    import ProductsTable from '../../components/client/orderConfirmation/ProductsTable.vue'
    import ThankYou from '../../components/client/orderConfirmation/ThankYou.vue'
    import TotalPrice from '../../components/client/orderConfirmation/TotalPrice.vue'

    export default {
        name: "OrderConfirmation",
        components: {
            RightPanel,
            ProductsTable,
            ThankYou,
            TotalPrice
        },
        data() {
            return {
                orderConfirm: null,
            }
        },
        created() {
            this.getOrder(this.$route.params.orderId)
        },
        methods: {
            getOrder(orderId) {
                this.$q.loading.show()
                this.$axios.get(`/api/client/order/${orderId}`)
                    .then(response => {
                        console.log(response)
                        this.orderConfirm = response.data
                        this.$q.loading.hide()
                    })
                    .catch(error => {
                        console.log(error)
                        this.$q.loading.hide()
                        this.$router.push({name: '404'})
                    })
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

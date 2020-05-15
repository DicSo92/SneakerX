<template>
    <div class="q-px-md">
      <div class="column">
        <div class="text-overline">
          Order Details :
        </div>
        <div class="q-pl-sm column">
          <div class="text-caption">
            Confirmation Email : {{orderConfirm.email}}
          </div>
          <div class="text-caption">
            Order Number : #{{orderConfirm.id}}
          </div>
          <div class="text-caption">
            Order Date : {{cFormatDate(orderConfirm.created_at)}}
          </div>
          <div class="text-caption">
            Estimated Delivery : {{dFormatDate(orderConfirm.created_at)}} (+6-8 days)
          </div>
        </div>
      </div>
      <q-separator spaced />
      <div class="column">
        <div class="text-overline">
          Invoice Informations :
        </div>
        <div class="q-pl-sm column">
          <div class="text-caption">
            {{orderConfirm.orders_billing_addresses.firstName + ' ' + orderConfirm.orders_billing_addresses.lastName}}
          </div>
          <div class="text-caption">
            {{orderConfirm.orders_billing_addresses.address + ' - ' + orderConfirm.orders_billing_addresses.postalCode + ', ' + orderConfirm.orders_billing_addresses.city}}
          </div>
          <div class="text-caption">
            {{orderConfirm.orders_billing_addresses.country}}
          </div>
          <div class="text-caption">
            Tel: {{orderConfirm.orders_billing_addresses.phone}}
          </div>
        </div>
      </div>
      <q-separator spaced />
      <div class="column" v-if="orderConfirm">
        <div class="text-overline">
          Delivery Informations :
        </div>
        <div class="q-pl-sm column">
          <div class="text-caption">
            {{orderConfirm.orders_delivery_addresses.firstName + ' ' + orderConfirm.orders_delivery_addresses.lastName}}
          </div>
          <div class="text-caption">
            {{orderConfirm.orders_delivery_addresses.address + ' - ' + orderConfirm.orders_delivery_addresses.postalCode + ', ' + orderConfirm.orders_delivery_addresses.city}}
          </div>
          <div class="text-caption">
            {{orderConfirm.orders_delivery_addresses.country}}
          </div>
          <div class="text-caption">
            Tel: {{orderConfirm.orders_delivery_addresses.phone}}
          </div>
        </div>
      </div>
      <q-separator spaced />
      <div class="column" v-if="orderConfirm">
        <div class="text-overline">
          Payment Method :
        </div>
        <div class="q-pl-sm row q-col-gutter-sm">
          <q-icon name="credit_card" size="md" class="col-auto"/>
          <div class="col column">
            <div class="text-bold">**** **** **** {{orderConfirm.cardNumbers}}</div>
            <div class="text-caption">
              Exp: {{orderConfirm.dateExp}}
            </div>
          </div>
        </div>
      </div>
      <q-separator spaced />
      <div class="column" v-if="orderConfirm">
        <div class="text-overline">
          Shipping Method :
        </div>
        <div class="q-pl-sm row q-col-gutter-sm">
          <q-icon name="local_shipping" size="md" class="col-auto"/>
          <div class="col column">
            <div class="text-bold">FREE</div>
            <div class="text-caption">
              6-8 Bussiness Days
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    import { date } from 'quasar'
    export default {
        name: "RightPanel",
        props: [
            'orderConfirm'
        ],
        data() {
            return {

            }
        },
        methods: {
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YYYY HH:mm')
            },
            dFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YYYY')
            },
        }
    }
</script>

<style scoped>

</style>

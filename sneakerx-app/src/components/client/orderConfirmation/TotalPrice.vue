<template>
  <div class="row justify-end full-width">
    <div class="col-lg-6 col-md-8 col-xs-12 q-pa-md bg-red-1">
      <div class="column">
        <div class="flex justify-between">
          <div class="text-subtitle1 text-bold">
            SubTotal :
          </div>
          <div class="text-subtitle1 text-bold">
            {{orderConfirm.totalPrice / 100}} €
          </div>
        </div>
        <div class="flex justify-between">
          <div class="text-caption">
            Delivery Charge (FREE) :
          </div>
          <div class="text-caption">
            0,00 €
          </div>
        </div>
      </div>
      <q-separator spaced/>
      <div class="column">
        <div class="flex justify-between">
          <div class="text-subtitle1 text-bold">
            Total without VAT :
          </div>
          <div class="text-subtitle1 text-bold">
            {{(orderConfirm.totalPrice * 0.8 / 100).toFixed(2)}} €
          </div>
        </div>
        <div class="flex justify-between">
          <div class="text-caption">
            VAT included : 20.0%
          </div>
          <div class="text-caption">
            {{orderConfirm.totalPrice / 100}} €
          </div>
        </div>
      </div>
      <q-separator spaced/>
      <div class="flex justify-between">
        <div class="text-h6 text-bold">
          TOTAL :
        </div>
        <div class="text-h6 text-bold">
          {{orderConfirm.totalPrice / 100}} €
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "TotalPrice",
        props: [
            'orderConfirm'
        ],
    }
</script>

<style scoped>

</style>

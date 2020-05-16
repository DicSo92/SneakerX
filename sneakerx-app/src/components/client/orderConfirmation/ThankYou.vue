<template>
  <div class="column">
    <div class="text-subtitle1 text-bold">
      Thank you for your purchase !
    </div>
    <q-separator class="q-mb-sm" style="min-height: 1px"/>
    <div class="column q-pl-sm">
      <div class="text-overline">
        Hoping to see you soon.
      </div>
      <div class="text-caption">
        You will receive an order confirmation email. If you don't ?
      </div>
      <div class="text-caption">
        Please <span class="text-primary">Contact us</span>.
      </div>
    </div>
    <q-btn class="full-width q-mt-sm"
           style="background: goldenrod; color: white"
           glossy label="Continue Buy"
           :to="{name: 'catalog'}"/>
  </div>
</template>

<script>
    export default {
        name: "ThankYou"
    }
</script>

<style scoped>

</style>

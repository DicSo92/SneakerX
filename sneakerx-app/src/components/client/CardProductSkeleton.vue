<template>
  <q-card flat square>
    <q-skeleton width="100%" height="250px" square/>
    <q-card-section>
      <q-skeleton type="text"/>
      <q-skeleton type="text"/>
      <q-skeleton type="text"/>
      <q-skeleton type="text"/>
    </q-card-section>

    <q-card-actions class="q-pt-none" style="border-bottom: 1px solid #eeeeee;">
      <q-skeleton type="QBtn"/>
      <q-space/>
      <q-skeleton type="QBtn"/>
    </q-card-actions>
  </q-card>
</template>

<script>
    export default {
        name: "CardProductSkeleton"
    }
</script>

<style scoped>

</style>

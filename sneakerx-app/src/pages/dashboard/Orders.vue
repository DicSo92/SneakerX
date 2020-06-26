<template>
  <q-page class="column items-center" padding>
    <q-card class="full-width">
      <q-card-section class="bg-grey-10 text-white flex full-width">
        <div class="text-h6">Order / List</div>
      </q-card-section>

      <q-separator/>

      <q-card-section>
        <OrderList></OrderList>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
    import OrderList from 'components/admin/orders/OrdersList.vue'

    export default {
        name: "Brands",
        components: {
            OrderList,
        },
        data() {
            return {

            }
        },
        created() {

        },
        mounted() {
        },
        computed: {},
        methods: {

        }
    }
</script>

<style scoped>

</style>

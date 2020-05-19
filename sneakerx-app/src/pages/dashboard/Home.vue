<template>
  <q-page class="column" padding>
    <div class="row q-gutter-md">
      <CardTotal v-for="total in totals"
                 :key="total.title + total.total"
                 :title="total.title"
                 :total="total.total"
                 class="col">
      </CardTotal>
    </div>
  </q-page>
</template>

<script>
    import CardTotal from 'components/admin/home/CardTotal.vue'

    export default {
        name: "Home",
        components: {
            CardTotal
        },
        data () {
            return {
                totals: [
                    {title: 'Total Users', total: 42 },
                    {title: 'Total Products', total: 15 },
                    {title: 'Total News', total: 63 },
                    {title: 'Total Comments', total: 157 },
                ]
            }
        }
    }
</script>

<style scoped>

</style>

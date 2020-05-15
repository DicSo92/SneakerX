<template>
  <q-tabs class="bg-blue-9 text-white shadow-2">
    <q-btn-dropdown auto-close
                    stretch flat
                    label="Brands">
      <q-list>
        <q-item clickable @click="tab = 'movies'">
          <q-item-section>Adidas</q-item-section>
        </q-item>
        <q-item clickable @click="tab = 'photos'">
          <q-item-section>Asics</q-item-section>
        </q-item>
        <q-item clickable @click="tab = 'photos'">
          <q-item-section>Puma</q-item-section>
        </q-item>
        <q-item clickable @click="tab = 'photos'">
          <q-item-section>Reebok</q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
    <q-route-tab :to="{name: 'catalog', query: {filter: 'soon'}}" exact label="UpComing" />
    <q-route-tab :to="{name: 'catalog', query: {filter: 'latest'}}" exact label="New" />
    <q-route-tab :to="{name: 'catalog'}" exact label="Catalog" />
<!--    <q-route-tab :to="{name: 'news'}" exact label="News" />-->
<!--    <q-route-tab :to="{name: 'contact'}" exact label="Contact" />-->
  </q-tabs>
</template>

<script>
    export default {
        name: "Tabs",
        data() {
            return {

            }
        },
    }
</script>

<style scoped>

</style>

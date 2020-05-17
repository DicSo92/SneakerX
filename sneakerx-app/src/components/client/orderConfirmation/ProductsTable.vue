<template>
  <q-table :data="orderConfirm.orders_products"
           :columns="columns"
           row-key="name"
           separator="cell"
           hide-bottom
           class="productTable">
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
        <q-td key="image" :props="props" class="columnImage" auto-width>
          <q-avatar rounded>
            <img :src="props.row.product.image ? props.row.product.image : 'statics/no-image.jpg'">
          </q-avatar>
        </q-td>
        <q-td key="name" :props="props">
          <div class="column">
            <div class="text-bold text-subtitle2">
              {{ props.row.product.name }}
            </div>
            <div class="text-overline">
              Price: {{props.row.product.price / 100}} €
            </div>
            <div class="text-overline">
              Color: {{props.row.color}}
            </div>
            <div class="text-overline">
              Size: {{props.row.size}}
            </div>
          </div>
        </q-td>
        <q-td key="quantity" :props="props" auto-width>
          <div class="text-pre-wrap text-bold">{{props.row.quantity}}</div>
        </q-td>
        <q-td key="totalPrice" :props="props" auto-width>
          <div class="text-pre-wrap text-bold">{{ (props.row.quantity * props.row.product.price) / 100}} €</div>
        </q-td>
      </q-tr>
    </template>

  </q-table>
</template>

<script>
    export default {
        name: "ProductsTable",
        props: [
            'orderConfirm'
        ],
        data() {
            return {
                columns: [
                    {name: 'image', align: 'center', label: 'Image', field: row => row},
                    {name: 'name', align: 'left', label: 'Name', field: row => row},
                    {name: 'quantity', align: 'center', label: 'Quantity', field: row => row},
                    {name: 'totalPrice', align: 'right', label: 'Total Price', field: row => row},
                ],
            }
        }
    }
</script>

<style scoped lang="scss">
  .productTable {
    box-shadow: none;
    max-width: 100%
  }
</style>

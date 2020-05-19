<template>
  <q-btn round flat icon="shopping_cart" class="q-mx-sm">
    <q-badge color="red" text-color="white" floating>
      {{getTotalCart}}
    </q-badge>
    <q-tooltip>Shopping Cart</q-tooltip>

    <q-menu :persistent="persistentMenu"
            :content-style="{minWidth: '320px'}"
            @hide="persistentMenu = false">
      <div class="text-h6 q-ma-sm">Shopping Cart</div>

      <q-separator/>

      <div class="listScrollable">
        <q-list>
          <q-item v-for="(product, index) in getCart"
                  :key="product.product.id + product.color.name + product.size"
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
              <q-item-label lines="1" class="text-bold">{{ product.product.name }} <span
                class="text-caption text-grey-8">- ADIDAS</span></q-item-label>
              <q-item-label caption>Color: {{product.color.name}} <span
                class="q-ml-md">Size: {{product.size}}</span></q-item-label>
              <div class="row">
                <q-select dense :value="getCart[index].total"
                          :options="quantities"
                          class="col-auto"
                          @input="productQuantityUpdate(product, product.total, $event)"/>
              </div>
            </q-item-section>

            <q-item-section side>
              <div class="column justify-between items-end full-height">
                <q-btn icon="delete" dense flat rounded class="q-mt-xs" size="sm" @click="removeProductCart(index)"/>
                <q-item-label caption>{{((product.product.price / 100) * product.total).toFixed(2)}} €
                </q-item-label>
              </div>
            </q-item-section>
          </q-item>
        </q-list>
      </div>

      <q-separator/>

      <div class="column q-ma-sm">
        <!--                <div class="text-caption">Récapitulatif :</div>-->
        <div class="column q-px-sm">
          <div class="flex justify-between">
            <div class="text-caption">SubTotal :</div>
            <div class="text-caption">{{getTotalPrice}} €</div>
          </div>
          <div class="flex justify-between">
            <div class="text-caption">Shipping :</div>
            <div class="text-caption">FREE</div>
          </div>
          <div class="flex justify-between">
            <div class="text-h6 text-bold">Total :</div>
            <div class="text-h6 text-bold">{{getTotalPrice}} €</div>
          </div>
        </div>
        <q-btn color="primary"
               label="Checkout"
               v-close-popup
               :to="{name: 'cart'}"/>
      </div>
    </q-menu>
  </q-btn>
</template>

<script>
    export default {
        name: "CartMenu",
        data() {
            return {
                quantities: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                persistentMenu: false
            }
        },
        components: {
        },
        watch: {
        },
        computed: {
            getTotalCart() {
                return this.getCart.reduce((a, b) => a + (b['total'] || 0), 0);
            },
            getTotalPrice() {
                let price = 0
                this.getCart.forEach(product => {
                    price += product.product.price * product.total
                })
                return (price / 100).toFixed(2)
            },
            getCart() {
                return this.$store.state.cart.cart;
            },
        },
        methods: {
            productQuantityUpdate(product, oldQuantity, newQuantity) {
                this.$store.dispatch('cart/updateStorageCart', {
                    product: product.product,
                    color: product.color,
                    size: product.size,
                    total: newQuantity - oldQuantity
                })
            },
            removeProductCart(productIndex) {
                this.persistentMenu = true
                this.$store.dispatch('cart/removeFromStorageCart', productIndex)
                // this.persistentMenu = false
            },
        },
    }
</script>

<style scoped lang="scss">
  .listScrollable {
    max-height: 30vh;
    overflow-y: auto;
  }
</style>

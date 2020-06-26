<template>
  <q-card>
    <q-list>
      <transition-group type="transition" name="flip-list">
        <q-item v-for="(product, index) in cart"
                :key="product.product.id + product.color.name + product.size"
                class="q-my-sm"
                clickable
                v-ripple>
          <q-item-section avatar>
            <q-img :src="product.product.image" class="listImage"/>
          </q-item-section>

          <q-item-section>
            <div class="column justify-between full-height q-py-sm">
              <div>
                <q-item-label lines="1" class="text-h6 text-bold">
                  {{ product.product.name }}
                  <span class="text-caption text-grey-8">- ADIDAS</span>
                </q-item-label>
                <q-item-label caption>
                  Color: {{product.color.name}}
                </q-item-label>
                <q-item-label caption>
                  Size: {{product.size}}
                </q-item-label>
                <q-item-label caption>
                  Price: {{product.product.price / 100}} €
                </q-item-label>
              </div>
              <div class="row">
                <q-select dense :value="cart[index].total"
                          label="Quantity"
                          :options="quantities"
                          class="col-auto" color="purple-9"
                          :style="{minWidth: '70px'}"
                          @input="productQuantityUpdate(product, product.total, $event)"/>
              </div>
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
      </transition-group>
    </q-list>
  </q-card>
</template>

<script>
    export default {
        name: "CartEdit",
        props: [
            'totalCart', 'totalPrice', 'cart'
        ],
        data() {
            return {
                quantities: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            }
        },
        components: {
        },
        watch: {
        },
        computed: {
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
                this.$store.dispatch('cart/removeFromStorageCart', productIndex)
                // this.persistentMenu = false
            },
        },
    }
</script>

<style scoped lang="scss">
  .listImage {
    width: 15vw;
    height: auto;
    max-width: 150px;
    min-width: 100px;
  }
</style>

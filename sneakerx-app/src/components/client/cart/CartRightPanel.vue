<template>
  <q-card>
    <q-card-section>
      <q-list bordered>
        <transition-group type="transition" name="flip-list">
          <q-item v-for="(product, index) in cart"
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
              <q-item-label lines="1" class="text-bold">
                <span>x{{product.total}} |</span>
                {{ product.product.name }}
                <span class="text-caption text-grey-8">- ADIDAS</span>
              </q-item-label>
              <q-item-label caption>
                Color: {{product.color.name}}
                <span class="q-ml-md">Size: {{product.size}}</span>
              </q-item-label>
            </q-item-section>

            <q-item-section side>
              <q-item-label caption>
                {{((product.product.price / 100) * product.total).toFixed(2)}} €
              </q-item-label>
            </q-item-section>
          </q-item>
        </transition-group>
      </q-list>

      <!--            <q-separator/>-->

      <div class="column q-ma-sm">
        <!--                <div class="text-caption">Récapitulatif :</div>-->
        <div class="column q-px-sm">
          <div class="flex justify-between">
            <div class="text-caption">SubTotal :</div>
            <div class="text-caption">{{totalPrice}} €</div>
          </div>
          <div class="flex justify-between">
            <div class="text-caption">Shipping :</div>
            <div class="text-caption">FREE</div>
          </div>
          <div class="flex justify-between">
            <div class="text-h6 text-bold">Total :</div>
            <div class="text-h6 text-bold">{{totalPrice}} €</div>
          </div>
        </div>
        <q-btn color="primary"
               :label="edit ? 'PROCEED TO PAYMENT' : 'EDIT COMMAND'"
               @click="command"/>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
    export default {
        name: "CartRightPanel",
        props: [
            'totalCart', 'totalPrice', 'cart', 'edit'
        ],
        data() {
            return {
            }
        },
        components: {
        },
        watch: {
        },
        computed: {
        },
        methods: {
            command() {
                this.$emit('changeLeftPanel')
            },
        },
    }
</script>

<style scoped>

</style>

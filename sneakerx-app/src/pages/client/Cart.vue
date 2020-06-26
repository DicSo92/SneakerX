<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center full-width">
      <div class="col-10">
        <div class="row full-width borderBottom q-mb-md">
          <h6 class="no-margin ">Cart :</h6>
        </div>

        <div class="row q-col-gutter-md full-width">
          <div class="col-xs-12 col-md-7">
            <CartEdit v-if="edit"
                      :cart="getCart"
                      :totalCart="getTotalCart"
                      :totalPrice="getTotalPrice">
            </CartEdit>
            <CartOrderStepper v-else>
            </CartOrderStepper>
          </div>
          <div class="col column">
            <recapRightPanel v-if="!edit">
            </recapRightPanel>
            <CartRightPanel :cart="getCart"
                            :totalCart="getTotalCart"
                            :totalPrice="getTotalPrice"
                            :edit="edit"
                            @changeLeftPanel="edit = !edit">
            </CartRightPanel>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
    import CartEdit from '../../components/client/cart/CartEdit.vue'
    import CartRightPanel from '../../components/client/cart/CartRightPanel.vue'
    import CartOrderStepper from '../../components/client/cart/CartOrderStepper.vue'
    import recapRightPanel from '../../components/client/cart/recapRightPanel.vue'

    export default {
        name: "Cart",
        data() {
            return {
                edit: true
            }
        },
        components: {
            CartEdit,
            CartRightPanel,
            CartOrderStepper,
            recapRightPanel,
        },
        created() {
            if (this.$router.currentRoute.query.stepper) this.edit = false
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
        },
    }
</script>

<style lang="scss">
.flip-list-move {
  transition: all 0.5s;
}
.flip-list-enter, .flip-list-leave-to {
  opacity: 0;
  transform: translateX(-50px);
}
.flip-list-leave-active {
  position: absolute;
  /*z-index: 10;*/
}
</style>

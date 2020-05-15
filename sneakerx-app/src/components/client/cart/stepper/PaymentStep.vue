<template>
    <div>
      <div class="text-overline q-mb-md">
        Please enter your bank details :
      </div>
      <div class="row q-col-gutter-lg">
        <div class="col-xs-12 col-sm">
          <div class="row q-col-gutter-sm">
            <q-input dense outlined v-model="cardName"
                     label="Name on card :"
                     placeholder="John Doe"
                     lazy-rules
                     :rules="[ val => val.length > 0 || 'Please type something']"
                     class="col-12">
              <template v-slot:before>
                <q-icon name="person" />
              </template>
            </q-input>
            <q-input dense outlined v-model="cardNumbers"
                     label="Card number :"
                     mask="card"
                     unmasked-value
                     placeholder="**** **** **** ****"
                     lazy-rules
                     :rules="[ val => val.length === 16 || 'Please type a correct card number']"
                     class="col-12">
              <template v-slot:before>
                <q-icon name="credit_card" />
              </template>
            </q-input>
            <q-input dense outlined v-model="dateExp"
                     label="Expire date"
                     mask="## / ####"
                     placeholder="01 / 2021"
                     lazy-rules
                     :rules="[ val => val.length > 8 || 'Please type a correct date']"
                     class="col">
              <template v-slot:before>
                <q-icon name="event" />
              </template>
            </q-input>
            <q-input dense outlined v-model="securityCode"
                     label="Security code :"
                     mask="###"
                     placeholder="111"
                     lazy-rules
                     :rules="[ val => val.length === 3 || 'Please type a correct security number']"
                     class="col">
              <template v-slot:prepend>
                <q-icon name="security" />
              </template>
            </q-input>
          </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-lg-3">
          <img :src="'/statics/creditCards.png'" style="max-width: 100%"/>
          <img :src="'/statics/verifiedByVisa.png'" style="max-width: 30%"/>
        </div>
      </div>


      <q-stepper-navigation>
        <q-btn color="primary"
               label="Confirm and Pay"
               icon="lock"
               :disable="!validatedCreditCard"
               @click="confirmOrder"/>
        <q-btn flat @click="changeStep(3)" color="primary" label="Back" class="q-ml-sm" />
      </q-stepper-navigation>
    </div>
</template>

<script>
    export default {
        name: "PaymentStep",
        props: [
            'billingAddressParent',
            'deliveryAddressParent',
            'isLoggedIn',
            'userState',
            'email'
        ],
        data () {
            return {
                cardName: '',
                cardNumbers: '',
                dateExp: '',
                securityCode: null
            }
        },
        created() {
        },
        methods: {
            changeStep(toStep) {
                this.$emit('changeStep', toStep)
            },
            confirmOrder() {
                if (this.isLoggedIn) {
                    this.createOrderForUser()
                } else {
                    this.createOrderNoAccount()
                }
            },
            createOrderNoAccount() {
                this.$axios.post('/api/client/order/no-account', {
                    products: JSON.stringify(this.getCart),
                    totalPrice: this.getTotalPrice,
                    email: this.email,
                    cardNumbers: this.cardNumbers.slice(-4),
                    dateExp: this.dateExp,
                    billingAddress: JSON.stringify(this.billingAddressParent),
                    deliveryAddress: JSON.stringify(this.deliveryAddressParent)
                })
                    .then(response => {
                        console.log(response);
                        this.$store.dispatch('cart/clearCart')
                        this.$router.push({ name: 'orderConfirmation', params: {orderId: response.data.id}})
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            createOrderForUser() {
                this.$axios.post('/api/client/order', {
                    products: JSON.stringify(this.getCart),
                    totalPrice: this.getTotalPrice,
                    cardNumbers: this.cardNumbers.slice(-4),
                    dateExp: this.dateExp,
                    billingAddress: JSON.stringify(this.billingAddressParent),
                    deliveryAddress: JSON.stringify(this.deliveryAddressParent)
                })
                    .then(response => {
                        console.log(response);
                        this.$store.dispatch('cart/clearCart')
                        this.$router.push({ name: 'orderConfirmation', params: {orderId: response.data.id}})
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        computed: {
            validatedCreditCard() {
                return this.cardName.length > 0 && this.cardNumbers.length === 16 && this.dateExp.length === 9 && this.securityCode.length === 3;
            },
            getTotalPriceToFixed() {
                let price = 0
                this.getCart.forEach(product => {
                    price += product.product.price * product.total
                })
                return (price / 100).toFixed(2)
            },
            getTotalPrice() {
                let price = 0
                this.getCart.forEach(product => {
                    price += product.product.price * product.total
                })
                return price
            },
            getCart() {
                return this.$store.state.cart.cart;
            },
        }
    }
</script>

<style scoped>

</style>

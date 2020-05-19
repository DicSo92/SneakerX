<template>
  <q-stepper v-model="step" vertical color="primary" animated>
    <q-step :name="1" title="Login or Continue without login" icon="settings" :done="step > 1">
      <IdentityStep :isLoggedIn="isLoggedIn"
                    :userState="userState"
                    :currentEmail="email"
                    @changeStep="toStep"
                    @changeEmail="email = $event">
      </IdentityStep>
    </q-step>

    <q-step :name="2" title="Invoice information" caption="Optional" icon="create_new_folder" :done="step > 2">
      <BillingStep v-if="isLoggedIn"
                   :billingAddressParent="billingAddress"
                   @changeStep="toStep"
                   @changeBillingAddress="billingAddress = $event"
                   @changeDeliveryAddress="deliveryAddress = $event">
      </BillingStep>

      <BillingStepNoAccount v-else
                            :billingAddressParent="JSON.stringify(billingAddress)"
                            @changeStep="toStep"
                            @changeBillingAddress="billingAddress = $event"
                            @changeDeliveryAddress="deliveryAddress = $event">
      </BillingStepNoAccount>

    </q-step>

    <q-step :name="3" title="Delivery Information" icon="assignment" :done="step > 1">
      <DeliveryStep v-if="isLoggedIn"
                    :billingAddressParent="billingAddress"
                    :deliveryAddressParent="deliveryAddress"
                    @changeStep="toStep"
                    @changeDeliveryAddress="deliveryAddress = $event">
      </DeliveryStep>

      <DeliveryStepNoAccount v-else
                             :billingAddressParent="JSON.stringify(billingAddress)"
                             :deliveryAddressParent="JSON.stringify(deliveryAddress)"
                             @changeStep="toStep"
                             @changeDeliveryAddress="deliveryAddress = $event">
      </DeliveryStepNoAccount>
    </q-step>

    <q-step :name="4" title="Payment Information" icon="add_comment">
      <PaymentStep :billingAddressParent="billingAddress"
                   :deliveryAddressParent="deliveryAddress"
                   :isLoggedIn="isLoggedIn"
                   :userState="userState"
                   :email="email"
                   @changeStep="toStep">
      </PaymentStep>
    </q-step>
  </q-stepper>
</template>

<script>
    import IdentityStep from './stepper/IdentityStep.vue'
    import BillingStep from './stepper/BillingStep.vue'
    import DeliveryStep from './stepper/DeliveryStep.vue'
    import PaymentStep from './stepper/PaymentStep.vue'

    import BillingStepNoAccount from './stepper/BillingStepNoAccount.vue'
    import DeliveryStepNoAccount from './stepper/DeliveryStepNoAccount.vue'

    export default {
        name: "CartCommand",
        components: {
            IdentityStep,
            BillingStep,
            DeliveryStep,
            PaymentStep,

            BillingStepNoAccount,
            DeliveryStepNoAccount
        },
        data () {
            return {
                step: 1,
                previouslySaveBilling: true, // Use if address isn't save and wouldn't be

                // sameAddressDeliveryInAddressBook: false,
                billingAddress: null,
                deliveryAddress: null,
                email: null
            }
        },
        watch: {
            billingAddress(val) {
                this.$root.$emit('billingAddressChange', val)
            },
            deliveryAddress(val) {
                this.$root.$emit('deliveryAddressChange', val)
            },
            email(val) {
                this.$root.$emit('emailChange', val)
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.state.auth.isLoggedIn
            },
            userState() {
                return this.$store.state.auth.user
            },
        },
        methods: {
            toStep(toStep) {
                this.step = toStep
            }
        }
    }
</script>

<style scoped>

</style>

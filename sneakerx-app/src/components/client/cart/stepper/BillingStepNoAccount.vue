<template>
  <div>
    <div class="column">
      <div class="text-caption">
        Please type your <span class="text-bold">billing address</span>.
      </div>

      <q-separator class="q-my-md" style="min-height: 1px"/>

      <div class="row q-col-gutter-sm q-mb-md">
        <q-input outlined dense
                 v-model="invoice.firstName"
                 label="Firstname..." class="col"
                 hint="First name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense
                 v-model="invoice.lastName"
                 label="Lastname..." class="col"
                 hint="Last name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense
                 v-model="invoice.address"
                 label="Address..." class="col-12"
                 hint="Address* (ex: 3 avenue john doe)"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense
                 v-model="invoice.additionalAddress"
                 label="Additional Address" class="col-12"
                 hint="Additional address"
        />
        <q-input outlined dense
                 v-model="invoice.postalCode"
                 label="Postal Code" class="col"
                 hint="Postal Code Number*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense
                 v-model="invoice.city"
                 label="City" class="col"
                 hint="City Name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-select outlined dense
                  v-model="invoice.country" :options="countryOptions"
                  label="Country" class="col-12"
                  hint="Country Name*"
                  :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense
                 v-model="invoice.phone"
                 label="Phone Number" class="col" type="tel"
                 hint="Telephone number*"
                 :rules="[val => !!val || 'Field is required']"
        />
      </div>

      <div class="column q-gutter-sm">
        <q-radio dense v-model="sameAddressDeliver" :val="true"
                 label="Deliver to this address"/>
        <q-radio dense v-model="sameAddressDeliver" :val="false"
                 label="Deliver to another address"/>
      </div>
    </div>
    <q-stepper-navigation>
      <q-btn color="primary"
             @click="nextStep"
             :disable="!newAddressValidated"
             label="Continue"/>
      <q-btn flat @click="changeStep(1)" color="primary" label="Back" class="q-ml-sm" />
    </q-stepper-navigation>
  </div>
</template>

<script>
    export default {
        name: "BillingStepNoAccount",
        props: [
            'billingAddressParent',
        ],
        data () {
            return {
                invoice: {
                    firstName: '',
                    lastName: '',
                    address: '',
                    additionalAddress: '',
                    postalCode: null,
                    city: '',
                    country: '',
                    phone: '',
                },
                countryOptions: [
                    'France', 'England', 'Spain', 'Germany', 'Netherlands', 'Italy'
                ],

                sameAddressDeliver: true,
                parentBillingAddress: JSON.parse(this.billingAddressParent)
            }
        },
        created() {
            if (this.parentBillingAddress) {
                this.invoice = this.parentBillingAddress
            }
        },
        methods: {
            changeStep(toStep) {
                this.$emit('changeStep', toStep)
            },
            nextStep() {
                this.$emit('changeBillingAddress', this.invoice)
                if (this.sameAddressDeliver) {
                    this.$emit('changeDeliveryAddress', this.invoice)
                    this.changeStep(4)
                } else {
                    this.changeStep(3)
                }
            },
        },
        computed: {
            newAddressValidated () {
                return !(!this.invoice.firstName || !this.invoice.lastName || !this.invoice.address || !this.invoice.postalCode || !this.invoice.city || !this.invoice.country || !this.invoice.phone);
            }
        }
    }
</script>

<style scoped>

</style>

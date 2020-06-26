<template>
  <div>
    <div class="column">
      <div class="text-caption">
        Please type your <span class="text-bold">delivery address</span>.
      </div>

      <q-separator class="q-my-md" style="min-height: 1px"/>

      <div class="row q-col-gutter-sm q-mb-md">
        <q-input outlined dense color="purple-10"
                 v-model="invoice.firstName"
                 label="Firstname..." class="col"
                 hint="First name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.lastName"
                 label="Lastname..." class="col"
                 hint="Last name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.address"
                 label="Address..." class="col-12"
                 hint="Address* (ex: 3 avenue john doe)"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.additionalAddress"
                 label="Additional Address" class="col-12"
                 hint="Additional address"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.postalCode"
                 label="Postal Code" class="col"
                 hint="Postal Code Number*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.city"
                 label="City" class="col"
                 hint="City Name*"
                 :rules="[val => !!val || 'Field is required']"
        />
        <q-select outlined dense color="purple-10"
                  v-model="invoice.country" :options="countryOptions"
                  label="Country" class="col-12"
                  hint="Country Name*"
                  :rules="[val => !!val || 'Field is required']"
        />
        <q-input outlined dense color="purple-10"
                 v-model="invoice.phone"
                 label="Phone Number" class="col" type="tel"
                 hint="Telephone number*"
                 :rules="[val => !!val || 'Field is required']"
        />
      </div>

      <div class="q-gutter-sm">
        <q-checkbox dense color="black"
                    v-model="useSameAsBilling"
                    @input="toggleSameAddress"
                    label="Use the billing address" class="col-12"
        />
      </div>
    </div>
    <q-stepper-navigation>
      <q-btn color="purple-10"
             @click="nextStep"
             :disable="!newAddressValidated"
             label="Continue"/>
      <q-btn flat @click="changeStep(2)" color="black" label="Back" class="q-ml-sm" />
    </q-stepper-navigation>
  </div>
</template>

<script>
    export default {
        name: "DeliveryStepNoAccount",
        props: [
            'billingAddressParent',
            'deliveryAddressParent'
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

                useSameAsBilling: false,
                parentDeliveryAddress: JSON.parse(this.deliveryAddressParent),
                parentBillingAddress: JSON.parse(this.billingAddressParent)
            }
        },
        created() {
            if (this.parentDeliveryAddress) {
                this.invoice = this.parentDeliveryAddress
            }
        },
        methods: {
            changeStep(toStep) {
                this.$emit('changeStep', toStep)
            },
            nextStep() {
                this.$emit('changeDeliveryAddress', this.invoice)
                this.changeStep(4)
            },
            toggleSameAddress(value) {
                if (value) {
                    this.invoice = this.parentBillingAddress
                } else {
                    if (this.parentDeliveryAddress && this.parentDeliveryAddress !== this.invoice) {
                        this.invoice = this.parentDeliveryAddress
                    } else {
                        this.invoice = {firstName: '', lastName: '', address: '', additionalAddress: '', postalCode: null, city: '', country: '', phone: '',}
                    }
                }
            }
        },
        watch: {

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

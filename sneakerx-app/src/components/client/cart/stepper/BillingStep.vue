<template>
  <div>
    <div class="column">
      <div class="text-caption q-mb-sm">
        Choose a billing address from your address book or enter a
        <span class="text-bold text-purple-10">new address</span>.
      </div>
      <q-select outlined dense color="purple-9"
                :loading="loadingAddressBook"
                :disable="loadingAddressBook"
                v-model="selectedAddress"
                :options="addressBookOptions"
                label="Choose Address..."
                :option-label="opt => !opt.newAddress ? `${opt.firstName} ${opt.lastName} - ${opt.address}, ${opt.postalCode} ${opt.city}, ${opt.country}` : opt.newAddress"
                emit-value
                map-options
      />

      <q-separator class="q-my-md" style="min-height: 1px"/>

      <div v-if="selectedAddress && selectedAddress.newAddress"
           class="row q-col-gutter-sm q-mb-md">
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
        <q-checkbox dense color="black"
                    v-model="saveAddress"
                    label="Save to Address book" class="col-12"
        />
      </div>

      <div class="column q-gutter-sm">
        <q-radio dense v-model="sameAddressDeliver" :val="true"
                 label="Deliver to this address" color="black"
                 :disable="!selectedAddress"/>
        <q-radio dense v-model="sameAddressDeliver" :val="false"
                 label="Deliver to another address" color="black"
                 :disable="!selectedAddress"/>
      </div>
    </div>
    <q-stepper-navigation>
      <q-btn :loading="loadingSaveNewAddress" color="purple-10"
             @click="nextStep"
             :disable="!newAddressValidated"
             label="Continue"/>
      <q-btn flat @click="changeStep(1)" color="black" label="Back" class="q-ml-sm" />
    </q-stepper-navigation>
  </div>
</template>

<script>
    export default {
        name: "BillingStep",
        props: [
            'billingAddressParent',
        ],
        data () {
            return {
                loadingSaveNewAddress: false,
                loadingAddressBook: false,

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

                saveAddress: false,
                sameAddressDeliver: true,

                selectedAddress: null,
                addressBookOptions: [{newAddress: 'New Address'}]
            }
        },
        created() {
            this.getAddressBook()
        },
        methods: {
            selectCurrentBillingAddress() {
                if (this.billingAddressParent) {
                    this.selectedAddress = this.billingAddressParent
                }
            },
            getAddressBook() {
                this.loadingAddressBook = true

                this.$axios.get('/api/client/addressBook')
                    .then(response => {
                        console.log(response);

                        let addressBook = response.data
                        addressBook.push({newAddress: 'New Address'})
                        this.addressBookOptions = addressBook
                        this.selectCurrentBillingAddress()
                        this.loadingAddressBook = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingAddressBook = false
                    })
            },
            changeStep(toStep) {
                this.$emit('changeStep', toStep)
            },
            nextStep() {
                if (this.selectedAddress.newAddress) {
                    if (this.saveAddress) {
                        this.saveToAddressBook()
                    } else {
                        this.$emit('changeBillingAddress', this.invoice)
                        if (this.sameAddressDeliver) {
                            this.$emit('changeDeliveryAddress', this.invoice)
                            this.changeStep(4)
                        } else {
                            this.changeStep(3)
                        }
                    }
                } else {
                    this.$emit('changeBillingAddress', this.selectedAddress)
                    if (this.sameAddressDeliver) {
                        this.$emit('changeDeliveryAddress', this.selectedAddress)
                        this.changeStep(4)
                    } else {
                        this.changeStep(3)
                    }
                }
            },
            saveToAddressBook() {
                this.loadingSaveNewAddress = true
                this.$axios.post('/api/client/addressBook', this.invoice)
                    .then(response => {
                        console.log(response);

                        this.$emit('changeBillingAddress', response.data)
                        this.loadingSaveNewAddress = false

                        if (this.sameAddressDeliver) {
                            this.$emit('changeDeliveryAddress', response.data)

                            this.changeStep(4)
                        } else {
                            this.changeStep(3)
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingSaveNewAddress = false
                    })
            }
        },
        computed: {
            newAddressValidated () {
                if (this.selectedAddress && !this.selectedAddress.newAddress) {
                    return true
                } else {
                    return !(!this.invoice.firstName || !this.invoice.lastName || !this.invoice.address || !this.invoice.postalCode || !this.invoice.city || !this.invoice.country || !this.invoice.phone);
                }
            }
        }
    }
</script>

<style scoped>

</style>

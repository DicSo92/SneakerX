<template>
  <div>
    <div class="column">
      <div class="text-caption q-mb-sm">
        Choose a delivery address from your address book or enter a
        <span class="text-bold text-primary">new address</span>.
      </div>
      <q-select outlined dense
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
        <q-checkbox dense
                    v-model="saveAddress"
                    label="Save to Address book" class="col-12"
        />
      </div>

      <div class="q-gutter-sm" v-if="!selectedAddress || selectedAddress && !selectedAddress.newAddress">
        <q-checkbox dense
                    v-model="useSameAsBilling"
                    @input="toggleSameAddress"
                    label="Use the billing address" class="col-12"
        />
      </div>
    </div>
    <q-stepper-navigation>
      <q-btn :loading="loadingSaveNewAddress" color="primary"
             @click="nextStep"
             :disable="!newAddressValidated"
             label="Continue"/>
      <q-btn flat @click="changeStep(2)" color="primary" label="Back" class="q-ml-sm" />
    </q-stepper-navigation>
  </div>
</template>

<script>
    export default {
        name: "BillingStep",
        props: [
            'billingAddressParent',
            'deliveryAddressParent'
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
                useSameAsBilling: false,

                selectedAddress: null,
                addressBookOptions: [{newAddress: 'New Address'}]
            }
        },
        created() {
            this.getAddressBook()
        },
        methods: {
            selectCurrentDeliveryAddress() {
                if (this.deliveryAddressParent) {
                    this.selectedAddress = this.deliveryAddressParent
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
                        this.selectCurrentDeliveryAddress()
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
                        this.$emit('changeDeliveryAddress', this.invoice)
                        this.changeStep(4)
                    }
                } else {
                    this.$emit('changeDeliveryAddress', this.selectedAddress)
                    this.changeStep(4)

                }
            },
            saveToAddressBook() {
                this.loadingSaveNewAddress = true
                this.$axios.post('/api/client/addressBook', this.invoice)
                    .then(response => {
                        console.log(response);

                        this.$emit('changeDeliveryAddress', response.data)
                        this.loadingSaveNewAddress = false
                        this.changeStep(4)
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingSaveNewAddress = false
                    })
            },
            toggleSameAddress(value) {
                if (value) {
                    this.selectedAddress = this.billingAddressParent
                } else {
                    this.selectedAddress = null
                }
            }
        },
        watch: {
            selectedAddress(val) {
                if (val) {
                    this.useSameAsBilling = val.id === this.billingAddressParent.id;
                }
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

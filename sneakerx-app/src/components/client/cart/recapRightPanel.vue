<template>
  <q-card class="q-mb-md">
    <q-card-section class="bg-primary text-white">
      <div class="text-subtitle2">Payment Progress</div>
    </q-card-section>

    <q-separator/>

    <q-card-section>
      <div class="text-overline">
        Account Informations :
      </div>
      <div class="column q-pl-sm">
        <div class="column" v-if="isLoggedIn && userState">
          <div class="text-caption">
            Connected as <span class="text-green-8 text-bold">{{userState.name}}</span>
          </div>
          <div class="text-subtitle2">
            Email : {{userState.email}}
          </div>
        </div>

        <div class="column" v-else>
          <div class="text-subtitle2" v-if="!email">
            Please <span class="text-bold">Log In</span> or enter an <span class="text-bold">Email</span> address.
          </div>
          <div class="text-subtitle2" v-else>
            Email : {{email}}
          </div>
        </div>
        <div class="text-caption text-negative text-weight-light" v-if="(isLoggedIn && userState) || email">
          Important. Confirmation email will be sent to this address
        </div>
      </div>
    </q-card-section>

    <q-separator/>

    <q-card-section>
      <div class="column" v-if="billingAddress">
        <div class="text-overline">
          Invoice Informations :
        </div>
        <div class="q-pl-sm column">
          <div class="text-caption">
            {{billingAddress.firstName + ' ' + billingAddress.lastName}}
          </div>
          <div class="text-caption">
            {{billingAddress.address + ' - ' + billingAddress.postalCode + ', ' + billingAddress.city}}
          </div>
          <div class="text-caption">
            {{billingAddress.country}}
          </div>
          <div class="text-caption">
            Tel: {{billingAddress.phone}}
          </div>
        </div>
      </div>
      <q-separator spaced v-if="billingAddress"/>
      <div class="column" v-if="deliveryAddress">
        <div class="text-overline">
          Delivery Informations :
        </div>
        <div class="q-pl-sm column">
          <div class="text-caption">
            {{deliveryAddress.firstName + ' ' + deliveryAddress.lastName}}
          </div>
          <div class="text-caption">
            {{deliveryAddress.address + ' - ' + deliveryAddress.postalCode + ', ' + deliveryAddress.city}}
          </div>
          <div class="text-caption">
            {{deliveryAddress.country}}
          </div>
          <div class="text-caption">
            Tel: {{deliveryAddress.phone}}
          </div>
        </div>
      </div>
    </q-card-section>

  </q-card>
</template>

<script>
    export default {
        name: "recapRightPanel",
        data() {
            return {
                billingAddress: null,
                deliveryAddress: null,
                email: null
            }
        },
        created() {
            this.$root.$on('billingAddressChange', (address) => {
                this.billingAddress = address
            })
            this.$root.$on('deliveryAddressChange', (address) => {
                this.deliveryAddress = address
            })
            this.$root.$on('emailChange', (email) => {
                this.email = email
            })
        },
        computed: {
            isLoggedIn() {
                return this.$store.state.auth.isLoggedIn
            },
            userState() {
                return this.$store.state.auth.user
            },
        }
    }
</script>

<style scoped>

</style>

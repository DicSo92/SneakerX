<template>
  <div>
    <div class="flex justify-between" v-if="isLoggedIn">
      <div class="column">
        <div class="text-caption" v-if="isLoggedIn && userState">
          Connected as <span class="text-green-8 text-bold">{{userState.name}}</span>
        </div>
        <div class="text-subtitle2" v-if="isLoggedIn && userState">
          Email : {{userState.email}}
        </div>
        <div class="text-caption text-negative text-weight-light">
          Important. Confirmation email will be sent to this address
        </div>
      </div>
      <div>
        <q-btn color="primary" outline label="LOGOUT" @click="logout" :loading="logoutLoading"/>
      </div>
    </div>
    <div class="column" v-else>
      <div class="text-overline text-center">
        Login to your account
      </div>
      <div class="text-caption q-mb-sm">
        Please <span class="text-bold">log in</span> to your account or create one to have access to your <span class="text-bold">address book</span>, <span class="text-bold">order summary</span>, <span class="text-bold">private coupons</span> and <span class="text-bold">personal support</span> from our staff.
      </div>
      <div class="flex">
        <q-btn color="primary" outline label="LOGIN / REGISTER" @click="loginRegister"/>
      </div>
      <div class="text-overline text-center text-bold q-mt-sm">
        OR
      </div>
      <div class="text-overline text-center">
        Continue without an account
      </div>
      <div class="text-caption q-mb-sm">
        Please type your email address where you want to receive the order confirmation.
      </div>
      <q-input filled dense
               v-model="email"
               type="email"
               label="Enter your Email Address"
               placeholder="john.doe@gmail.com"
               :rules="[val => !!val || 'Email is missing', isValidEmailInput]"
               hint="Enter a Valid Email"/>
    </div>
    <q-stepper-navigation>
      <q-btn color="primary"
             @click="changeStep(2)"
             :disable="disableContinue"
             label="Continue"/>
    </q-stepper-navigation>
  </div>
</template>

<script>
    export default {
        name: "IdentityStep",
        props: [
            'isLoggedIn',
            'userState',
            'currentEmail'
        ],
        data() {
            return {
                email: '',
                logoutLoading: false
            }
        },
        created() {
            this.email = this.currentEmail
        },
        computed: {
            disableContinue() {
                if (this.isLoggedIn) {
                    return false
                } else {
                    return !this.isValidEmail;
                }
            },
            isValidEmail() {
                const emailPattern = /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/;
                return emailPattern.test(this.email);
            },
        },
        methods: {
            isValidEmailInput (val) {
                const emailPattern = /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/;
                return emailPattern.test(val) || 'Invalid email';
            },
            changeStep(toStep) {
                this.$emit('changeEmail', this.email)
                this.$emit('changeStep', toStep)
            },
            loginRegister() {
                this.$router.push({name: 'auth', query: { fromCart: 'true'} })
            },
            logout() {
                this.logoutLoading = true
                this.$axios.post('/api/logout').then(response => {
                    console.log(response)
                    this.$store.dispatch('auth/logout')
                    this.logoutLoading = false
                }).catch(error => {
                    console.log(error)
                    this.$store.dispatch('auth/logout')
                    this.logoutLoading = false
                })
            },
        }
    }
</script>

<style scoped>

</style>

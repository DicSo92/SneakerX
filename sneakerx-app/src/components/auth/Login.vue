<template>
  <div class="login">
    <div class="text-h6">Login</div>
    <q-form
      @submit="login"
      @reset="reset"
      class="q-gutter-md"
    >
      <q-input
        filled color="purple-9"
        type="email"
        autocomplete="email"
        v-model="email"
        label="Your email *"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled color="purple-9"
        type="password"
        autocomplete="current-password"
        v-model="password"
        label="Your password *"
        lazy-rules
        :rules="[val => val !== null && val !== '' || 'Please type your password']"
      />

      <q-toggle v-model="accept" label="I accept the license and terms" color="purple-9"/>

      <div>
        <q-btn label="LogIn" type="submit" color="purple-10" icon="lock"/>
        <q-btn label="Reset" type="reset" color="black" flat class="q-ml-sm"/>
      </div>
    </q-form>
  </div>
</template>

<script>
  import {logIn} from '../../utils/auth'
  import bus from '../../utils/bus.js'

  export default {
        name: "Login",
        data() {
            return {
                tab: 'login',

                email: null,
                password: null,
                accept: false,

                loading: false,
            }
        },
        watch: {
            loading(isLoading) {
                if (isLoading) {
                    this.$q.loading.show()
                } else {
                    this.$q.loading.hide()
                }
            }
        },
        created (){
            bus.$on('hideLoginLoading', (redirect) => {
                this.loading = false
                if (redirect) this.$router.push({name: 'home'})
            })
        },
        beforeDestroy () {
            this.$q.loading.hide()
            bus.$off('hideLoginLoading')
        },
        methods: {
            login() {
                if (this.accept !== true) {
                    console.log('You need to accept the license and terms first')
                } else {
                    this.loading = true
                    this.$axios.get('/sanctum/csrf-cookie')
                        .then(response => {
                            console.log(response)
                            this.$axios.post('/api/login', {
                                email: this.email,
                                password: this.password
                            }).then(res => {
                                console.log('-----------')
                                console.log(res)
                                logIn()
                                this.$store.dispatch('auth/loadUser', 'login')
                                // ^^^^^^ bus emit hideLoading ^^^^^^ //
                            }).catch(res => {
                                console.log('error ----')
                                console.log(res)
                                this.loading = false
                            })
                        });
                }
            },
            reset() {
                this.name = null
                this.age = null
                this.accept = false
            }
        }
    }
</script>

<style scoped>

</style>

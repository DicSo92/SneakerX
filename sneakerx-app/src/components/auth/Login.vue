<template>
  <div class="login">
    <div class="text-h6">Login</div>
    <q-form
      @submit="onSubmit"
      @reset="onReset"
      class="q-gutter-md"
    >
      <q-input
        filled
        type="email"
        autocomplete="email"
        v-model="email"
        label="Your email *"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        type="password"
        autocomplete="current-password"
        v-model="password"
        label="Your password *"
        lazy-rules
        :rules="[
                val => val !== null && val !== '' || 'Please type your password',
              ]"
      />

      <q-toggle v-model="accept" label="I accept the license and terms"/>

      <div>
        <q-btn label="LogIn" type="submit" color="primary"/>
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm"/>
      </div>
    </q-form>
    <h6 v-if="loading">Loading</h6>
  </div>
</template>

<script>
  import {logIn} from '../../utils/auth'
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
        methods: {
            onSubmit() {
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
                                this.$store.dispatch('auth/loadUser')
                                this.loading = false
                                // this.$router.push({name: 'home'})

                            }).catch(res => {
                                console.log('error ----')
                                console.log(res)
                            })
                        });
                }
            },
            logout() {

            },

            onReset() {
                this.name = null
                this.age = null
                this.accept = false
            }
        }
    }
</script>

<style scoped>

</style>

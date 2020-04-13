<template>
  <div class="register">
    <div class="text-h6">Register</div>

    <q-form
      @submit="onSubmit"
      @reset="onReset"
      class="q-gutter-md"
    >
      <q-input
        filled
        v-model="user.name"
        label="Enter your name *"
        hint="Name and surname"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />
      <q-input
        filled
        type="email"
        autocomplete="email"
        v-model="user.email"
        label="Enter your email *"
        lazy-rules
        :rules="[val => val && val.length > 0 || 'Please type something']"
      />

      <q-input
        filled
        type="password"
        autocomplete="new-password"
        v-model="user.password"
        label="Enter your password *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please type your password',
        ]"
      />

      <q-input
        filled
        type="password"
        autocomplete="new-password"
        v-model="user.password_confirmation"
        label="Confirm your password *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please confirm your password',
          val => val !== null && val !== '' && val === user.password || 'Wrong Password'
        ]"
      />

      <q-toggle v-model="accept" label="I accept the license and terms"/>

      <p class="text-negative"
         v-if="errors.email">
        {{errors.email[0]}}
      </p>

      <div>
        <q-btn label="Register" type="submit" color="primary" icon="lock"/>
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm"/>
      </div>
    </q-form>
  </div>
</template>

<script>
    import {logIn} from '../../utils/auth'
    import bus from '../../utils/bus.js'

    export default {
        name: "Register",
        data() {
            return {
                tab: 'login',

                user: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                },

                accept: false,
                errors: {},
                loading: false
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
            bus.$on('hideLoading', (redirect) => {
                this.loading = false
                if (redirect) this.$router.push({name: 'home'})
            })
        },
        beforeDestroy () {
            this.$q.loading.hide()
        },
        methods: {
            onSubmit() {
                if (this.accept !== true) {
                    console.log('You need to accept the license and terms first')
                } else {
                    this.loading = true
                    this.$axios.post('/api/register', this.user)
                        .then(response => {
                            console.log(response)
                            this.$axios.get('/sanctum/csrf-cookie')
                                .then(res => {
                                    console.log(res)
                                    logIn()
                                    this.$store.dispatch('auth/loadUser')
                                    // ^^^^^^ bus emit hideLoading ^^^^^^ //
                                }).catch(er => {
                                    console.log(er)
                                this.loading = false
                            })
                        }).catch(error => {
                            console.log(error)
                            if (422 === error.response.status) {
                                this.errors = error.response.data.errors
                            }
                            this.loading = false
                        })
                }
            },

            onReset() {
                this.email = null
                this.password = null
                this.confirmPassword = null
                this.accept = false
            }
        }
    }
</script>

<style scoped>

</style>

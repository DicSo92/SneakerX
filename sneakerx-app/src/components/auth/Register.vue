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
        v-model="name"
        label="Your name *"
        hint="Name and surname"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Please type something']"
      />
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
        autocomplete="new-password"
        v-model="password"
        label="Your password *"
        lazy-rules
        :rules="[
          val => val !== null && val !== '' || 'Please type your password',
        ]"
      />

      <q-toggle v-model="accept" label="I accept the license and terms"/>

      <div>
        <q-btn label="Submit" type="submit" color="primary"/>
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm"/>
      </div>
    </q-form>
  </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                tab: 'login',

                name: null,
                email: null,
                password: null,

                accept: false
            }
        },
        methods: {
            onSubmit() {
                if (this.accept !== true) {
                    console.log('You need to accept the license and terms first')
                } else {
                    console.log('user create')
                }
            },

            onReset() {
                this.email = null
                this.password = null
                this.accept = false
            }
        }
    }
</script>

<style scoped>

</style>

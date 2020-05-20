<template>
  <q-page class="flex flex-center">
    <div class="containerCard row flex-center">
      <q-card class="col-xs-11 col-sm-9 col-md-6 col-lg-4">
        <q-tabs
          v-model="tab"
          dense
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab name="login" label="Login"/>
          <q-tab name="register" label="Register"/>
        </q-tabs>

        <q-separator/>

        <q-tab-panels v-model="tab" animated>

          <q-tab-panel name="login">
            <Login></Login>
          </q-tab-panel>
          <q-tab-panel name="register">
            <Register></Register>
          </q-tab-panel>

        </q-tab-panels>
      </q-card>
    </div>
  </q-page>
</template>

<script>
  import Login from '../components/auth/Login.vue'
  import Register from '../components/auth/Register.vue'

    export default {
        name: 'PageIndex',
        components: {
            Login,
            Register
        },
        data() {
            return {
                tab: 'login',
            }
        },
        methods: {

        }
    }
</script>

<style lang="scss">
  .containerCard {
    width: 100%;
  }
</style>

<template>
  <q-btn-dropdown flat no-wrap label="Account" icon="person">
    <q-list dense>
      <q-item>
        <q-item-section>
          <div>Signed in as <strong>Mary</strong></div>
        </q-item-section>
      </q-item>
      <q-separator/>
      <q-item clickable>
        <q-item-section>Dashboard</q-item-section>
      </q-item>
      <q-separator/>
      <q-item clickable>
        <q-item-section>Your profile</q-item-section>
      </q-item>
      <q-item clickable>
        <q-item-section>Your orders</q-item-section>
      </q-item>
      <q-item clickable>
        <q-item-section>Your stars</q-item-section>
      </q-item>
      <q-separator/>
      <q-item clickable>
        <q-item-section>Help</q-item-section>
      </q-item>
      <q-item clickable @click="logout">
        <q-item-section>Sign out</q-item-section>
      </q-item>
    </q-list>
  </q-btn-dropdown>
</template>

<script>
    export default {
        name: "AccountMenu",
        data() {
            return {

            }
        },
        components: {
        },
        watch: {
        },
        methods: {
            logout() {
                this.$axios.post('/api/logout').then(response => {
                    console.log(response)
                    this.$store.dispatch('auth/logout')
                    this.$router.push({name: 'auth'})
                }).catch(error => {
                    console.log(error)
                    this.$store.dispatch('auth/logout')
                })
            },
        },
    }
</script>

<style scoped>

</style>

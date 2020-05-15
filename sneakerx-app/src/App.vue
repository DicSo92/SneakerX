<template>
  <div id="q-app">
    <router-view/>
  </div>
</template>

<script>
    import bus from './utils/bus.js'

    export default {
        name: 'App',
        beforeCreate: function () {
            console.log('beforeCreate')
            this.$q.loading.show()

            this.$store.dispatch('auth/loadUser', 'firstLoad')
            this.$store.dispatch('cart/getStorageCart')

            bus.$on('hideFirstLoading', () => {
                this.$q.loading.hide()
            })
        },
        created (){

        },
    }
</script>

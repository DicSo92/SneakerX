<template>
  <div id="q-app">
    <router-view/>
  </div>
</template>

<script>
    export default {
        name: 'App',
        beforeCreate: function () {
            console.log('beforeCreate')
            this.$store.dispatch('auth/loadUser')
        }
    }
</script>

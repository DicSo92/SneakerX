<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-grey-10">
      <q-toolbar>
        <q-toolbar-title class="cursor-pointer" @click="goToHome">
          <q-avatar square  class="q-mr-sm">
            <img src="statics/IconSX-8.png">
          </q-avatar>
          SneakerX
        </q-toolbar-title>

        <q-input dark dense standout v-model="search" input-class="text-right" style="flex-grow: 1">
          <template v-slot:append>
            <q-icon v-if="search === ''" name="search" />
            <q-icon v-else name="clear" class="cursor-pointer" @click="search = ''" />
          </template>
        </q-input>

        <CartMenu></CartMenu>

        <AccountMenu v-if="isLoggedIn"></AccountMenu>
        <q-btn v-else flat no-wrap label="Login / Register" :to="{name: 'auth'}" icon="person" />
      </q-toolbar>

      <Tabs></Tabs>
    </q-header>

    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script>
    import EssentialLink from 'components/EssentialLink'
    import CartMenu from 'components/layouts/CartMenu'
    import AccountMenu from 'components/layouts/AccountMenu'
    import Tabs from 'components/layouts/Tabs'

    export default {
        name: 'MainLayout',
        data() {
            return {
                search: ''
            }
        },
        components: {
            EssentialLink,
            CartMenu,
            AccountMenu,
            Tabs
        },
        watch: {
        },
        computed: {
            isLoggedIn() {
                return this.$store.state.auth.isLoggedIn
            },
            userState() {
                return this.$store.state.auth.user
            },
            links() {
                const home = {
                    title: 'Home',
                    caption: 'Home',
                    icon: 'home',
                    link: 'home'
                }
                const auth = {
                    title: 'Login / Register',
                    caption: 'login.register',
                    icon: 'code',
                    link: 'auth'
                }
                const catalog = {
                    title: 'Catalog',
                    caption: 'products.catalog',
                    icon: 'dashboard',
                    link: 'catalog'
                }
                if (this.isLoggedIn) {
                    return [home, catalog]
                } else {
                    return [home, catalog, auth]
                }
            }
        },
        methods: {
            goToHome() {
                this.$router.push({name: 'home'})
            }
        },
    }
</script>

<style lang="scss">

</style>

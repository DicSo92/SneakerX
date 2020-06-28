<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-grey-10">
      <q-toolbar>
        <q-toolbar-title class="cursor-pointer" @click="goToHome">
          <q-avatar square class="q-mr-sm">
            <img src="statics/IconSX-8.png">
          </q-avatar>
          SneakerX
        </q-toolbar-title>

        <q-input dark dense standout v-model="search" input-class="text-right" style="flex-grow: 1"
                 @keyup.enter="goToSearch" ref="searchbar">
          <template v-slot:append>
            <q-icon v-if="search === ''" name="search"/>
            <q-icon v-else name="clear" class="cursor-pointer" @click="search = ''"/>
          </template>
        </q-input>

        <CartMenu></CartMenu>

        <AccountMenu v-if="isLoggedIn"></AccountMenu>
        <q-btn v-else flat no-wrap label="Login / Register" :to="{name: 'auth'}" icon="person"/>
      </q-toolbar>

      <Tabs></Tabs>
    </q-header>

    <q-page-container>
      <div class="row justify-center">
        <div class="col-10 q-px-md">
          <div class="bottom-line q-py-md">
            <q-breadcrumbs style="font-size: 16px">
              <q-breadcrumbs-el label="Home" icon="home" :to="{name: 'home'}"/>
              <q-breadcrumbs-el v-for="li in links"
                                :key="li.title"
                                :label="li.title"
                                :icon="li.icon"
                                :to="{name: li.link}"
                                v-if="currentRoute === li.link && li.link !== 'home'"
              />
            </q-breadcrumbs>
          </div>
        </div>
      </div>
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
        watch: {},
        computed: {
            currentRoute() {
                return this.$route.name
            },
            isLoggedIn() {
                return this.$store.state.auth.isLoggedIn
            },
            userState() {
                return this.$store.state.auth.user
            },
            links() {
                const home = {
                    title: 'Home',
                    icon: 'home',
                    link: 'home'
                }
                const auth = {
                    title: 'Login / Register',
                    icon: 'code',
                    link: 'auth'
                }
                const catalog = {
                    title: 'Catalog',
                    icon: 'widgets',
                    link: 'catalog'
                }
                const product = {
                    title: 'Product',
                    icon: 'dashboard',
                    link: 'catalog/:slug'
                }
                const news = {
                    title: 'News',
                    icon: 'fiber_new',
                    link: 'news'
                }
                const actuality = {
                    title: 'Actuality',
                    icon: 'fiber_new',
                    link: 'news/:slug'
                }
                const search = {
                    title: 'Search',
                    icon: 'search',
                    link: 'search'
                }
                const contact = {
                    title: 'Contact',
                    icon: 'mail',
                    link: 'contact'
                }
                const cart = {
                    title: 'Cart',
                    icon: 'shopping_cart',
                    link: 'cart'
                }
                const orderConfirmation = {
                    title: 'Order Confirmation',
                    icon: 'shopping_cart',
                    link: 'orderConfirmation/:orderId'
                }
                return [home, auth, catalog, product, news, actuality, search, contact, cart, orderConfirmation]
            }
        },
        methods: {
            goToHome() {
                this.$router.push({name: 'home'})
            },
            goToSearch() {
                console.log(this.search)
                this.$router.push({name: 'search', query: {search: this.search}})
                this.search = ''
                this.$refs.searchbar.blur()
            }
        },
    }
</script>

<style scoped lang="scss">
    .bottom-line {
        border-bottom: solid 1px #dedede;
    }
</style>

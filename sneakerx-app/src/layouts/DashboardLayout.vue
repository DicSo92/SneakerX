<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round
               icon="menu"
               aria-label="Menu"
               @click="leftDrawerOpen = !leftDrawerOpen"/>
        <q-toolbar-title>
          DashBoard
        </q-toolbar-title>
      </q-toolbar>
      <q-toolbar inset>
        <q-breadcrumbs active-color="white" style="font-size: 16px">
          <q-breadcrumbs-el label="Home" icon="home" :to="{name: 'home_admin'}"/>
          <q-breadcrumbs-el label="Products" icon="widgets" v-if="currentRoute === 'products_admin'"/>
          <q-breadcrumbs-el label="Brands" icon="local_offer" v-if="currentRoute === 'brands_admin'"/>
          <q-breadcrumbs-el label="Users" icon="group" v-if="currentRoute === 'users_admin'"/>
        </q-breadcrumbs>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen"
              show-if-above
              bordered
              content-class="bg-grey-1">
      <q-list>
        <q-item-label header
                      class="text-grey-8">
          Essential Links
        </q-item-label>

        <EssentialLink v-for="link in links"
                       :key="link.title"
                       v-bind="link"/>

      </q-list>
    </q-drawer>

    <q-page-container>
      <transition
        :duration="700"
        mode="out-in"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut"
      >
        <router-view/>
      </transition>
    </q-page-container>

  </q-layout>
</template>

<script>
    import EssentialLink from 'components/EssentialLink'

    export default {
        name: "DashboardLayout",

        components: {
            EssentialLink
        },

        data() {
            return {
                leftDrawerOpen: false,
            }
        },
        watch: {
            currentRoute(val) {
                console.log(val);
            }
        },
        computed: {
            currentRoute() {
                return this.$route.name
            },
            links() {
                const home = {
                    title: 'Home',
                    caption: 'Home',
                    icon: 'home',
                    link: 'home'
                }
                const products = {
                    title: 'Products',
                    caption: 'list.products',
                    icon: 'widgets',
                    link: 'products_admin'
                }
                const users = {
                    title: 'Users',
                    caption: 'list.users',
                    icon: 'group',
                    link: 'users_admin'
                }
                const categories = {
                    title: 'Categories',
                    caption: 'list.categories',
                    icon: 'category',
                    link: 'categories_admin'
                }
                const brands = {
                    title: 'Brands',
                    caption: 'list.brands',
                    icon: 'local_offer',
                    link: 'brands_admin'
                }
                return [home, products, users, categories, brands]
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>

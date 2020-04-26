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
      <router-view/>
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
        computed: {
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

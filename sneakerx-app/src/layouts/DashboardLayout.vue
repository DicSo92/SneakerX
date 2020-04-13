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

        <EssentialLink v-for="link in essentialLinks"
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
                essentialLinks: [
                    {
                        title: 'Home',
                        caption: 'Home',
                        icon: 'home',
                        link: 'home'
                    },
                    {
                        title: 'Login / Register',
                        caption: 'login.register',
                        icon: 'code',
                        link: 'auth'
                    },
                    {
                        title: 'Users',
                        caption: 'list.users',
                        icon: 'group',
                        link: 'users_admin'
                    },
                    {
                        title: 'Categories',
                        caption: 'list.categories',
                        icon: 'category',
                        link: 'categories_admin'
                    },
                    {
                        title: 'Brands',
                        caption: 'list.brands',
                        icon: 'local_offer',
                        link: 'brands_admin'
                    },
                    {
                        title: 'Articles',
                        caption: 'list.articles',
                        icon: 'widgets',
                        link: 'articles_admin'
                    },
                ]
            }
        },
        computed: {

        },
        methods: {

        }
    }
</script>

<style scoped>

</style>

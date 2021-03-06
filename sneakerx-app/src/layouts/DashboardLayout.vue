<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated class="bg-grey-10">
      <q-toolbar>
        <q-btn flat dense round
               icon="menu"
               aria-label="Menu"
               @click="toggleMenu"/>
        <q-toolbar-title>
          DashBoard
        </q-toolbar-title>
      </q-toolbar>
      <q-toolbar inset class="bg-purple-9">
        <q-breadcrumbs active-color="white" style="font-size: 16px">
          <q-breadcrumbs-el label="Home" icon="home" :to="{name: 'home_admin'}"/>
          <q-breadcrumbs-el v-for="li in links"
                            :key="li.title"
                            :label="li.title"
                            :icon="li.icon"
                            :to="{name: li.link}"
                            v-if="currentRoute === li.link && li.link !== 'home_admin'"
          />
        </q-breadcrumbs>
        <q-space/>
        <q-toggle
          v-model="animation"
          checked-icon="check"
          color="green"
          label="Animations :"
          left-label
          unchecked-icon="clear"
        />
        <q-toggle
          v-model="darkMode"
          checked-icon="check"
          color="green"
          label="Dark Mode (Beta) :"
          left-label
          unchecked-icon="clear"
        />
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen"
              show-if-above
              :mini="!leftDrawerOpen || miniState"
              :mini-to-overlay="$q.screen.xs || $q.screen.sm"
              :breakpoint="500"
              bordered
              content-class="bg-grey-1">
      <q-list>
        <q-item-label header class="text-grey-8">
          Welcome <span class="text-bold">{{authUser.name}}</span>,
        </q-item-label>

        <q-item clickable tag="a" :class="miniState ? 'q-mt-xl' : ''" :to="{name: 'home'}">
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>

          <q-item-section>
            <q-item-label>Go To Website</q-item-label>
            <q-item-label caption>website.home</q-item-label>
          </q-item-section>
        </q-item>

        <q-separator class="q-my-md"/>

        <EssentialLink v-for="link in links"
                       :key="link.title"
                       v-bind="link"/>

      </q-list>
      <div class="q-mini-drawer-hide absolute"
           style="top: 15px; right: -17px"
           v-if="$q.screen.xs || $q.screen.sm">
        <q-btn dense round unelevated color="accent" icon="chevron_left" @click="miniState = true"/>
      </div>
    </q-drawer>

    <q-page-container>
      <transition
        :duration="700"
        mode="out-in"
        :enter-active-class="'animated ' + animationName.enter"
        :leave-active-class="'animated ' + animationName.leave"
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
                miniState: false,

                animation: false,
                darkMode: this.$q.dark.isActive
            }
        },
        watch: {
            currentRoute(val) {
                console.log(val);
            },
            darkMode(val) {
                this.setDarkMode(val)
            }
        },
        computed: {
            animationName() {
                return this.animation ? {enter: 'fadeInLeft', leave: 'fadeOutLeft'} : {enter: 'fadeIn', leave: 'fadeOut'}
            },
            authUser () {
                return this.$store.state.auth.user
            },
            currentRoute() {
                return this.$route.name
            },
            links() {
                const homeDash = {
                    title: 'Dashboard',
                    caption: 'dashboard.home',
                    icon: 'dashboard',
                    link: 'home_admin'
                }
                const news = {
                    title: 'News',
                    caption: 'list.news',
                    icon: 'fiber_new',
                    link: 'news_admin'
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
                const brands = {
                    title: 'Brands',
                    caption: 'list.brands',
                    icon: 'local_offer',
                    link: 'brands_admin'
                }
                const orders = {
                    title: 'Orders',
                    caption: 'list.orders',
                    icon: 'shopping_cart',
                    link: 'orders_admin'
                }
                const roles = {
                    title: 'Roles',
                    caption: 'list.roles',
                    icon: 'pan_tool',
                    link: 'roles_admin'
                }
                const activityLogs = {
                    title: 'Activity Logs',
                    caption: 'list.activityLogs',
                    icon: 'code',
                    link: 'activityLogs_admin'
                }
                return [homeDash, users, news, products, brands, orders, roles, activityLogs]
            }
        },
        methods: {
            setDarkMode(status) {
                this.$q.dark.set(status)
            },
            toggleMenu () {
                // this.leftDrawerOpen = !this.leftDrawerOpen

                this.miniState = !this.miniState
            },
        }
    }
</script>

<style scoped>

</style>

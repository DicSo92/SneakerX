<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round
               icon="menu"
               aria-label="Menu"
               @click="leftDrawerOpen = !leftDrawerOpen"/>
        <q-toolbar-title>
          Quasar App
        </q-toolbar-title>

        <q-btn dense flat no-wrap v-if="this.isLoggedIn">
          <q-avatar rounded size="20px">
            <img src="https://cdn.quasar.dev/img/avatar3.jpg">
          </q-avatar>
          <q-icon name="arrow_drop_down" size="16px"/>

          <q-menu auto-close>
            <q-list dense>
              <q-item class="GL__menu-link-signed-in">
                <q-item-section>
                  <div>Signed in as <strong>Mary</strong></div>
                </q-item-section>
              </q-item>
              <q-separator/>
              <q-item clickable class="GL__menu-link">
                <q-item-section>Your profile</q-item-section>
              </q-item>
              <q-item clickable class="GL__menu-link">
                <q-item-section>Your stars</q-item-section>
              </q-item>
              <q-separator/>
              <q-item clickable class="GL__menu-link">
                <q-item-section>Help</q-item-section>
              </q-item>
              <q-item clickable class="GL__menu-link">
                <q-item-section>Settings</q-item-section>
              </q-item>
              <q-item clickable class="GL__menu-link" @click="logout">
                <q-item-section>Sign out</q-item-section>
              </q-item>
            </q-list>
          </q-menu>

        </q-btn>
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
        name: 'MainLayout',

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
                ]
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.state.auth.isLoggedIn
            }
        },
        methods: {
            logout() {
                this.$axios.post('/api/logout').then(response => {
                    console.log(response)
                    this.$store.dispatch('auth/logout')
                }).catch(error => {
                    console.log(error)
                    this.$store.dispatch('auth/logout')

                })
            }
        }
    }
</script>

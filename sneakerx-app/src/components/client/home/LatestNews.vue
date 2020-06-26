<template>
  <div class="q-pa-md">
    <div class="row justify-center q-pa-md">
      <div class="text-h6" style="text-decoration: underline">
        LATEST NEWS
      </div>
    </div>

    <transition
      :duration="300"
      mode="out-in"
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut">
      <div class="row justify-start items-start q-col-gutter-lg" v-if="!loading">
        <div class="col-lg-4 col-sm-6 col-xs-12" v-for="actuality in news">
          <CardActuality :actuality="actuality"/>
        </div>
      </div>
    </transition>
    <transition
      :duration="300"
      mode="out-in"
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut">
      <div class="row justify-start items-start q-col-gutter-lg" v-if="loading">
        <div class="col-lg-4 col-sm-6 col-xs-12" v-for="actuality in nbPerPage">
          <CardActualitySkeleton/>
        </div>
      </div>
    </transition>

    <div class="row justify-end q-mt-md">
      <q-btn outline color="black" label="VIEW ALL" icon-right="chevron_right" @click="goTo('news')"/>
    </div>

  </div>
</template>

<script>
    import CardActuality from '../CardActuality.vue'
    import CardActualitySkeleton from '../CardActualitySkeleton.vue'

    export default {
        name: "LatestNews",
        components: {
            CardActuality,
            CardActualitySkeleton
        },
        data() {
            return {
                news: null,
                nbPerPage: 6,

                loading: true
            }
        },
        created() {
            this.getNews(1, this.nbPerPage)
        },
        watch: {},
        computed: {},

        methods: {
            getNews(page, nb) {
                this.loading = true
                this.$axios.get(`/api/client/news?page=${page}&nb=${nb}`)
                    .then(response => {
                        console.log(response)
                        this.news = response.data.data
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            },
            goTo(route) {
                this.$router.push({name: route})
            }
        }
    }
</script>

<style scoped>

</style>

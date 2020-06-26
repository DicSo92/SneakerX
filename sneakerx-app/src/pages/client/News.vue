<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center full-width">
      <div class="col-10">
        <div class="row full-width borderBottom q-mb-md">
          <h6 class="no-margin ">News :</h6>
        </div>

        <div class="column items-center full-width">
          <div class="flex full-width justify-between items-center q-mb-sm">
            <p class="no-margin" v-if="totalNews">
              Total News : {{totalNews}}
            </p>
            <div class="flex">
              <q-select v-model="nbPerPage"
                        :options="selectNbPerPage"
                        label="Per Page"
                        style="min-width: 80px" dense
              />
              <q-pagination v-if="maxPages"
                            v-model="page"
                            color="black"
                            :max="maxPages"
                            :input="true">
              </q-pagination>
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
              <div class="col-lg-4 col-sm-6 col-xs-12" v-for="key in nbPerPage" :key="key">
                <CardProductSkeleton />
              </div>
            </div>
          </transition>

          <div class="flex flex-center q-mb-md">
            <q-pagination
              v-if="!loading"
              v-model="page"
              :max="maxPages"
              color="black"
              :direction-links="true"
              :boundary-links="true"
              icon-first="skip_previous"
              icon-last="skip_next"
              icon-prev="fast_rewind"
              icon-next="fast_forward"
            >
            </q-pagination>
          </div>

        </div>
      </div>
    </div>

  </q-page>
</template>

<script>
    import CardActuality from '../../components/client/CardActuality.vue'
    import CardProductSkeleton from '../../components/client/CardProductSkeleton.vue'

    export default {
        name: 'News',
        components: {
            CardActuality,
            CardProductSkeleton
        },
        data() {
            return {
                news: null,

                page: 1,
                nbPerPage: 8,
                maxPages: null,
                totalNews: null,

                selectNbPerPage: [4, 8, 12, 16, 20],

                loading: true
            }
        },
        created() {
            this.getNews(this.page, this.nbPerPage)
        },
        watch: {
            nbPerPage(val) {
                this.getNews(this.page, val)
            },
            page(val) {
                this.getNews(val, this.nbPerPage)
            }
        },
        computed: {},
        methods: {
            getNews(page, nb) {
                this.loading = true
                this.$axios.get(`/api/client/news?page=${page}&nb=${nb}`)
                    .then(response => {
                        console.log(response)
                        this.news = response.data.data
                        this.maxPages = response.data.last_page
                        this.totalNews = response.data.total
                        this.loading = false
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>

<style scoped lang="scss">
  .borderBottom {
    border-bottom: 1px #eeeeee solid;
  }
</style>

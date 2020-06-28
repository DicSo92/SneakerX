<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center full-width">
      <div class="col-10">
        <div class="row full-width borderBottom q-mb-md">
          <h6 class="no-margin ">Actuality :</h6>
        </div>

        <ActualityShow :actuality="actuality"/>
      </div>
    </div>
  </q-page>
</template>

<script>
    import ActualityShow from '../../components/client/actuality/ActualityShow.vue'

    export default {
        name: "Actuality",
        components: {
            ActualityShow
        },
        data() {
            return {
                actuality: null,
                loading: false
            }
        },
        created() {
            this.getActuality(this.$route.params.slug)
        },
        methods: {
            getActuality(slug) {
                this.loading = true
                this.$axios.get(`/api/client/news/${slug}`)
                    .then(response => {
                        console.log(response)
                        this.actuality = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped>

</style>

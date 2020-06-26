<template>
  <q-page>
    <Carousel/>
    <div class="row justify-center">
      <div class="col-10">
        <NewProducts/>
        <LatestNews/>
      </div>
    </div>
  </q-page>
</template>

<script>
    import Carousel from '../components/client/home/Carousel.vue'
    import NewProducts from '../components/client/home/NewProducts.vue'
    import LatestNews from '../components/client/home/LatestNews.vue'

    export default {
        name: 'PageIndex',
        components: {
            Carousel,
            NewProducts,
            LatestNews
        }
    }
</script>

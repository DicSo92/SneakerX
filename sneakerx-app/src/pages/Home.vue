<template>
  <q-page>
<!--    <div class="row justify-center">-->
<!--      <div class="col-7">-->
<!--        <Carousel/>-->
<!--      </div>-->
<!--    </div>-->
    <Carousel/>
  </q-page>
</template>

<script>
    import Carousel from '../components/client/home/Carousel.vue'

    export default {
        name: 'PageIndex',
        components: {
            Carousel
        }
    }
</script>

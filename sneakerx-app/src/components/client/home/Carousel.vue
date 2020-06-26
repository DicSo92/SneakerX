<template>
  <div class="q-pa-md">
      <q-carousel
        :height="responsiveCarousel"
        animated
        v-model="slide"
        navigation
        infinite
      >
        <q-carousel-slide :name="1" class="uncropped-image" img-src="~assets/20180725_nike_996x350-men.jpg"/>
        <q-carousel-slide :name="2" class="uncropped-image" img-src="~assets/adidas_men_april_Carousel_Banner_996x350_2.jpg"/>
        <q-carousel-slide :name="3" class="uncropped-image" img-src="~assets/Landing_Page_Banner-lacoste.jpg"/>
        <q-carousel-slide :name="4" class="uncropped-image" img-src="~assets/Men_201903_ShoesSneakers_CarouselBanner1.jpg"/>
      </q-carousel>
  </div>
</template>

<script>
    export default {
        name: "Carousel",
        data () {
            return {
                slide: 1
            }
        },
        computed: {
            responsiveCarousel() {
                if (this.$q.screen.lg || this.$q.screen.xl ) {
                    return '575px'
                } else if (this.$q.screen.md) {
                    return  '400px'
                } else if (this.$q.screen.sm) {
                    return '300px'
                } else {
                    return '200px'
                }
            }
        },
    }
</script>

<style scoped lang="scss">
  .uncropped-image {
    background-size: contain;  /* don't crop the image  */
    background-repeat: no-repeat;  /* only show the image one time  */
    background-color: #f1f1f1;  /* color to fill empty space with  */
  }
</style>

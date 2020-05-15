<template>
  <div class="row q-col-gutter-md full-width">
<!--    <div class="col-7 flex flex-center">-->
<!--      <div class="full-width full-height flex flex-center bg-grey-2">-->
<!--        <img-->
<!--          class="mainImage"-->
<!--          :src="product.image"-->
<!--        />-->
<!--      </div>-->
<!--    </div>-->
    <div class="col-7">
      <q-carousel
        :height="responsiveCarousel"
        swipeable
        animated
        v-model="slide"
        thumbnails
        :autoplay="autoplay"
        :fullscreen.sync="fullscreen"
        infinite>
        <q-carousel-slide class="" :name="1" :img-src="product.image" />
        <q-carousel-slide class="" :name="2" :img-src="product.image" />
        <q-carousel-slide class="" :name="3" :img-src="product.image" />
        <q-carousel-slide class="" :name="4" :img-src="product.image" />

        <template v-slot:control>
          <q-carousel-control
            position="top-right"
            :offset="[18, 18]"
            class="text-white rounded-borders"
            style="background: rgba(0, 0, 0, .3); padding: 4px 8px;"
          >
            <q-toggle dense dark color="orange" v-model="autoplay" label="Auto" />
          </q-carousel-control>
          <q-carousel-control
            position="bottom-right"
            :offset="[18, 18]"
          >
            <q-btn
              push round dense color="white" text-color="primary"
              :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'"
              @click="fullscreen = !fullscreen"
            />
          </q-carousel-control>
        </template>
      </q-carousel>
    </div>

    <div class="col-5">
      <q-card class="my-card" flat bordered>
        <q-card-section>
          <div class="flex justify-between items-center">
            <div class="flex">
              <img
                src="https://res.cloudinary.com/charly-luzzi/image/upload/v1588357088/SneakerX/Brands/dnrcuzv7etmjjqck5wbn.png"
                class="brandImage">
              <div class="row no-wrap items-center">
                <q-rating size="18px" v-model="stars" :max="5" color="primary"/>
                <span class="text-caption text-grey q-ml-sm">4.2 (551)</span>
              </div>
            </div>
            <div class="text-h6">
              {{product.price / 100}} €
            </div>
          </div>
        </q-card-section>
        <q-separator/>

        <q-card-section>
          <div class="">
            <div class="text-h6">{{product.name}}</div>
            <div class="text-overline">
              {{product.brand}}
            </div>
            <div class="text-body2">
              {{product.description}}
            </div>
          </div>
        </q-card-section>
        <q-separator/>
        <q-card-section>
          <div class="row q-gutter-sm items-center">
            <div class="col-auto cursor-pointer"
                 v-for="color in product.colors"
                 :class="colorSelected.name === color.name ? 'colorSelected' : ''"
                 @click="colorSelected = color">
              <div class="squareColor" :style="{background: color.color}">
                <q-tooltip>{{color.name}}</q-tooltip>
              </div>
            </div>
          </div>
          <div class="row full-width q-my-sm">
            <q-select square outlined v-model="size" :options="sizes" label="Choose a Size" class="col"/>
            <q-select square outlined v-model="quantity" :options="quantities" class="col-auto q-ml-sm"/>
          </div>
          <div class="row">
            <q-btn color="red" icon="shopping_cart" icon-right="send" label="Order" align="between" class="col" @click="addToCart"/>
            <q-btn outline round color="primary" icon="favorite" class="col-auto q-ml-sm"/>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
    export default {
        name: "ProductShow",
        props: [
            'product'
        ],
        data() {
            return {
                fullscreen: false,
                autoplay: false,
                slide: 1,
                stars: 4,

                sizes: [36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52],
                quantities: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                size: 42,
                quantity: 1,
                colorSelected: this.product.colors[0],
            }
        },
        computed: {
            responsiveCarousel() {
                return this.$q.screen.lg || this.$q.screen.xl ? '500px' : ''
            }
        },
        created() {
            // this.colorSelected = this.colors[0]
        },
        methods: {
            addToCart() {
                this.$store.dispatch('cart/updateStorageCart', {product: this.product, color: this.colorSelected, size: this.size, total: this.quantity})
            },
        }
    }
</script>

<style scoped lang="scss">
  .squareColor {
    width: 30px;
    height: 30px;
    /*border: 1px white solid;*/
    border-radius: 3px;
  }

  .colorSelected {
    border: 2px solid #1976D2;
  }

  .mainImage {
    max-height: 33vh;
    width: auto;
  }

  .brandImage {
    max-height: 30px;
  }
</style>

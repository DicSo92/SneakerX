<template>
  <q-card class="column justify-between full-height" square flat>
    <q-img @click="goToProduct(product.slug)"
           class="cursor-pointer"
           :src="product.image"
           style="width: 100%; height: auto"
           basic>
      <div class="absolute-bottom text-subtitle2 productName">
        {{product.name}}
      </div>
    </q-img>

    <q-card-section>
      {{product.description | truncate(100, '...')}}
    </q-card-section>

    <q-card-actions class="q-pt-none" style="border-bottom: 1px solid #eeeeee;">
      <q-btn flat>
        {{ product.price / 100 }} €
      </q-btn>
      <q-space/>
      <q-btn flat round color="black" icon="shopping_cart"  @click.stop="addToCart(product)"/>
    </q-card-actions>
  </q-card>
</template>

<script>
    export default {
        name: "CardProduct",
        props: [
            'product'
        ],
        filters: {
            truncate: function (text, length, suffix) {
                if (text.length > length) {
                    return text.substring(0, length) + suffix;
                } else {
                    return text;
                }
            },
        },
        methods: {
            goToProduct(slug) {
                console.log('go to');
                this.$router.push({name: 'product', params: {slug: slug}})
            },
            addToCart(product) {
                console.log(product)
                this.$store.dispatch('cart/updateStorageCart', {product, color: product.colors[0], size: product.sizes[0].size, total: 1})
            },
        }
    }
</script>

<style scoped lang="scss">
  .productName {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.6);
  }
</style>

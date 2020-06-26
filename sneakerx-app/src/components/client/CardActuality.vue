<template>
  <q-card class="my-card" square flat>
    <img :src="actuality.image">

    <q-card-section>
      <div class="row items-center">
        <div class="bg-black text-overline q-px-md q-mr-sm text-white">
          {{ actuality.subtitle }}
        </div>
        <div class="text-grey-5">
          {{actuality.published_date}}
        </div>
      </div>
      <div class="text-h6 title">{{ actuality.title }}</div>
    </q-card-section>

    <q-card-section class="q-pt-none">
      {{actuality.content | truncate(250, '...')}}
    </q-card-section>
  </q-card>
</template>

<script>
    export default {
        name: "CardActuality",
        props: [
            'actuality'
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
    }
</script>

<style scoped lang="scss">
  .title {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    text-transform: uppercase
  }
</style>

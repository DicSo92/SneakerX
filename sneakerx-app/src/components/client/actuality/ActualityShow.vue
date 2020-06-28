<template>
  <div class="full-width">
    <div class="row items-center">
      <div class="bg-black text-overline q-px-md q-mr-sm text-white">
        {{ actuality.subtitle }}
      </div>
      <div class="text-grey-5">
        {{actuality.published_date}}
      </div>
    </div>

    <div class="text-h4 title text-bold q-mt-sm">{{ actuality.title }}</div>

    <div class="row q-col-gutter-lg  q-py-lg">
      <div class="row justify-center col-6">
        <img :src="actuality.image" class="full-width">
      </div>
      <div class="content text-body1 col-6">
        {{actuality.content}}
      </div>
    </div>

  </div>
</template>

<script>

    export default {
        name: "ActualityShow",
        props: [
            'actuality'
        ]

    }
</script>

<style scoped lang="scss">
  .title {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    text-transform: uppercase
  }
  .content {

  }
</style>

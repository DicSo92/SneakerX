<template>
  <q-card bordered class="my-card bg-teal-4 column justify-around">
    <q-card-section>
      <div class="row items-center no-wrap">
        <div class="col-2">
          <q-icon name="local_offer" size="md"/>
        </div>
        <div class="col offset-md-1">
          <div class="text-subtitle2">{{title}}</div>
<!--          <div class="text-subtitle2">by John Doe</div>-->
        </div>

        <div class="col-auto">
          <q-btn color="grey-7" round flat icon="more_vert">
            <q-menu cover auto-close>
              <q-list>
                <q-item clickable>
                  <q-item-section>Remove Card</q-item-section>
                </q-item>
                <q-item clickable>
                  <q-item-section>Send Feedback</q-item-section>
                </q-item>
                <q-item clickable>
                  <q-item-section>Share</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </div>
      </div>
      <div class="row">
        <div class="col-3"></div>
        <div class="col">
          <div class="text-h4 text-bold no-margin">{{ total }}</div>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
    export default {
        name: "cardTotal",
        props: ['title', 'total'],
    }
</script>

<style scoped>

</style>

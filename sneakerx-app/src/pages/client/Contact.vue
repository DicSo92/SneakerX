<template>
  <q-page class="flex column justify-start items-center" padding>
    <div class="row justify-center full-width">
      <div class="col-10">
        <div class="row q-col-gutter-xl">
          <div class="col-6">
            <q-img src="~assets/contactBanner.jpg">
              <div class="absolute-full flex flex-center">
                <div class="column items-center">
                  <div class="text-h5 text-center">
                    60 quai de Jemmapes, 75010 Paris
                  </div>
                  <div class="text-h5 text-center q-py-md">
                    contact@ecole-webstart.com
                  </div>
                  <div class="text-h5 text-center">
                    Tél: 01 42 41 97 76
                  </div>
                </div>
              </div>
            </q-img>
          </div>
          <div class="col-6">
            <Form/>
          </div>
        </div>
        <div class="q-mt-lg">
          <iframe width="100%"
                  height="300"
                  frameborder="0" style="border:0"
                  :src="'https://www.google.com/maps/embed/v1/place?key=' + 'AIzaSyDYW1IOQqIaP-2g3vGUXmfh1nMwJBR6-2U' + '&q=19+Rue+Yves+Toudic,+75010+Paris'"
                  allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
    import Form from '../../components/client/contact/Form.vue'

    export default {
        name: "Contact",
        components: {
            Form
        },
    }
</script>

<style scoped>

</style>

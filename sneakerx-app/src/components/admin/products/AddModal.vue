<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 1100px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="addBrand"
          class="q-gutter-md"
        >
          <div class="row">
            <div class="col-3" v-if="image">
              <q-img
                src="http://res.cloudinary.com/charly-luzzi/image/upload/v1588357094/SneakerX/Products/Adidas/superstar-originals/e5k42tybhaxhnx6tkjrr.jpg"
                style="width: 100%; height: auto"
              />
            </div>
            <q-uploader
              v-else
              label="Image (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              class="col-auto"
              @added="toggleImagesData($event, true, 'image')"
              @removed="toggleImagesData($event, false, 'image')"
            />
            <div class="col q-px-md column ">
              <div class="row items-start q-gutter-md">
                <q-input filled v-model="name" label="Brand Name *"
                         class="col-8"
                         hint="Main Name"
                         lazy-rules
                         :rules="[ val => val && val.length > 0 || 'Please type something']"
                />
                <q-select color="teal-4" class="col"
                          filled
                          v-model="brandSelected"
                          :options="brands"
                          option-value="id"
                          option-label="name"
                          option-disable="inactive"
                          emit-value
                          map-options
                          label="Select Brand">
                  <template v-slot:prepend>
                    <q-icon name="local_offer"/>
                  </template>
                </q-select>
              </div>

              <div class="row q-mt-md">
                <div class="column col-6">
                  <div class="flex q-mb-sm">
                    <q-icon name="colorize" size="sm" color="purple"/>
                    <div class="text-subtitle2 q-ml-xs">Colors* :</div>
                    <div class="text-caption text-negative q-ml-sm">No colors selected*</div>
                  </div>
                  <div class="flex">
                    <q-btn dense rounded no-caps size="sm" icon-right="add" glossy color="deep-orange">
                      <q-popup-proxy transition-show="scale" transition-hide="scale">
                        <q-color v-model="colorPicker"/>
                      </q-popup-proxy>
                    </q-btn>
                  </div>
                </div>
                <q-separator vertical class="q-mx-md"/>
              </div>
            </div>
          </div>

          <q-editor v-model="description" min-height="8rem"/>

          <div class="flex justify-between">
            <q-uploader
              label="Banner (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              @added="toggleImagesData($event, true, 'banner')"
              @removed="toggleImagesData($event, false, 'banner')"

            />
            <q-uploader
              label="Image (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              @added="toggleImagesData($event, true, 'image')"
              @removed="toggleImagesData($event, false, 'image')"
            />
          </div>


          <div class="column">
            <q-toggle v-model="directActive" label="Check to instantly publish product on catalog. (Not recommended)"/>
            <div>
              <q-btn :loading="loading" color="primary" label="Submit" type="submit" icon-right="send">
                <template v-slot:loading>
                  <q-spinner-hourglass class="on-left"/>
                  Loading...
                </template>
              </q-btn>
              <q-btn label="Cancel" @click="showEdit = false" color="primary" flat class="q-ml-sm"/>
            </div>


          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
    export default {
        name: "AddModal",
        props: [
            'brands'
        ],
        data() {
            return {
                showEdit: false,
                name: '',
                description: '',
                bannerFile: null,
                imageFile: null,

                loading: false,

                image: true,
                brandSelected: null,
                colorPicker: '#B33636',
                directActive: false
            }
        },
        mounted() {
            this.$root.$on('showAddProduct', show => {
                this.showEdit = !!show
            })
        },
        methods: {
            addBrand() {
                console.log('Fake Submit');
            },
            toggleImagesData(files, added, qFor) {
                if (qFor === 'banner') {
                    this.bannerFile = added ? files[0] : null
                } else if (qFor === 'image') {
                    this.imageFile = added ? files[0] : null
                }
            }
        },
    }
</script>

<style scoped>

</style>

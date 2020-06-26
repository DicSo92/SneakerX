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
                src="http://res.cloudinary.com/charly-luzzi/image/upload/v1589846305/SneakerX/Products/Adidas/superstar-originals/knn2rqqaqdbczodbjvwp.jpg"
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
                <ColorsPicker :colorsProps="colors" class="col"
                              @colorsChange="colors = $event">
                </ColorsPicker>

                <q-separator vertical class="q-mx-md"/>

                <SizesPicker :sizesProps="sizes" class="col"
                             @sizesChange="sizes = $event">
                </SizesPicker>
              </div>
            </div>
          </div>

          <q-editor v-model="description" min-height="8rem"/>

          <div class="flex justify-between">
            <q-uploader
              label="Images List (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              multiple
              @added="toggleImagesData($event, true, 'banner')"
              @removed="toggleImagesData($event, false, 'banner')"
              class="full-width" style="min-height: 300px"
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
    import draggable from "vuedraggable";
    import ColorsPicker from "./ColorsPicker.vue";
    import SizesPicker from "./SizesPicker.vue";

    export default {
        name: "AddModal",
        props: [
            'brands'
        ],
        components: {
            draggable,
            SizesPicker,
            ColorsPicker
        },
        data() {
            return {
                showEdit: false,
                loading: false,

                image: true,
                name: '',
                description: '',
                brandSelected: null,
                colors: [],
                sizes: [],
                directActive: false,

                bannerFile: null,
                imageFile: null,
            }
        },
        mounted() {
            this.$root.$on('showAddProduct', show => {
                this.showEdit = !!show
            })
        },
        watch: {},
        computed: {
        },
        methods: {
            addBrand() {
                console.log('Fake Submit');
            },
            toggleImagesData(files, added, bannerOrImage) {
                if (bannerOrImage === 'banner') {
                    this.bannerFile = added ? files[0] : null
                } else if (bannerOrImage === 'image') {
                    this.imageFile = added ? files[0] : null
                }
            }
        },
    }
</script>

<style scoped lang="scss">
  .listSizesContainer {
    border: solid 1px #eeeeee;
  }
</style>

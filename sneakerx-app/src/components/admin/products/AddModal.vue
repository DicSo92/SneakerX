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
                <ColorsPicker :colorsProps="colors" class="col"
                              @colorsChange="changeColorsOnEmit">
                </ColorsPicker>

                <q-separator vertical class="q-mx-md"/>

                <div class="col column">
                  <div class="flex q-mb-sm q-pb-sm" style="border-bottom: solid 1px #eeeeee;">
                    <q-icon name="colorize" size="sm" color="purple"/>
                    <div class="text-subtitle2 q-ml-xs">Sizes* :</div>
                    <div class="text-caption text-negative q-ml-sm" v-if="!sizesAsc.length">No sizes selected*</div>
                    <q-space/>
                  </div>
                  <q-select
                    filled
                    dense
                    v-model="sizes"
                    multiple
                    :options="sizeOptions"
                    option-label="size"
                    label="Choose Sizes"
                    counter
                    hint="Counter Sizes"
                    class="full-width q-mb-md">

                    <template v-if="sizes.length" v-slot:append>
                      <q-icon name="cancel" @click.stop="sizes = []" class="cursor-pointer"/>
                    </template>
                  </q-select>
                  <div class="flex">
                    <q-chip v-for="(size, index) in sizesAsc" :key="size.size"
                            dense
                            removable
                            @remove="sizes.splice(index, 1)" class="text-positive">
                      <q-avatar color="red" text-color="white">{{size.size}}</q-avatar>
                      Available
                    </q-chip>
                  </div>
                </div>

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
    import draggable from "vuedraggable";
    import ColorsPicker from "./ColorsPicker.vue";

    export default {
        name: "AddModal",
        props: [
            'brands'
        ],
        components: {
            draggable,
            ColorsPicker
        },
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
                directActive: false,

                colors: [],

                sizes: [],
                sizeOptions: [{size: 34, available: true}, {size: 35, available: true}, {
                    size: 36,
                    available: true
                }, {size: 37, available: true}, {size: 38, available: true}, {size: 39, available: true}, {
                    size: 40,
                    available: true
                }, {size: 41, available: true}, {size: 42, available: true}, {size: 43, available: true}, {
                    size: 44,
                    available: true
                }, {size: 45, available: true}, {size: 46, available: true}, {size: 47, available: true}, {
                    size: 48,
                    available: true
                }, {size: 49, available: true}, {size: 50, available: true}, {size: 51, available: true}, {
                    size: 52,
                    available: true
                }]
            }
        },
        mounted() {
            this.$root.$on('showAddProduct', show => {
                this.showEdit = !!show
            })
        },
        watch: {},
        computed: {
            sizesAsc() {
                return this.sizes.sort(this.sizesAscComparison)
            }
        },
        methods: {
            sizesAscComparison(a, b) {
                let comparison = 0;
                if (a.size > b.size) {
                    comparison = 1;
                } else if (a.size < b.size) {
                    comparison = -1;
                }
                return comparison;
            },
            changeColorsOnEmit(colors) {
                this.colors = colors
            },
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

<style scoped lang="scss">
  .listSizesContainer {
    border: solid 1px #eeeeee;
  }
</style>

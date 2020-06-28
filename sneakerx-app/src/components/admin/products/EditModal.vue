<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 1100px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="editProduct"
          class="q-gutter-md"
        >
          <div class="row">
            <div class="col-3 flex justify-center items-start relative-position" v-if="currentImage">
              <q-btn round :loading="loadingImage" color="red-9" size='md' icon="delete" class="deleteBtn"
                     @click="removeFromImage">
                <template v-slot:loading>
                  <q-spinner-facebook/>
                </template>
              </q-btn>
              <q-img
                :src="currentImage"
                style="width: 100%; height: auto"
              />
            </div>
            <q-uploader
              square color="grey-10" v-else
              label="Main Image (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn :disable="imageToUploadLoading"
              class="col-auto"
              @added="toggleImagesData($event, true, 'image')"
              @removed="toggleImagesData($event, false, 'image')"
            />
            <div class="col q-px-md column ">
              <div class="row items-start q-gutter-md">
                <q-input filled v-model="name" label="Brand Name *"
                         class="col-6"
                         hint="Main Name"
                         lazy-rules color="purple-10"
                         :rules="[ val => val && val.length > 0 || 'Please type something']"
                />
                <q-select color="purple-10" class="col"
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
                <q-input filled bottom-slots v-model="price" label="Price"
                         hint="Product Price"
                         class="col-2"
                         mask="#.##"
                         fill-mask="0"
                         reverse-fill-mask>
                  <template v-slot:append>
                    <q-icon name="euro_symbol"/>
                  </template>
                </q-input>
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

          <q-editor v-model="description" min-height="8rem" toolbar-toggle-color="yellow-9"/>

          <div class="row q-col-gutter-lg q-pa-md">
            <div class="col-8">
              <div class="q-col-gutter-md row items-start">
                <div class="col-3 relative-position" v-for="(image, index) in currentImages">
                  <q-btn round :loading="loadingImages === index" dense color="red-9" size='md' icon="delete" class="deleteBtnImages"
                         @click="removeFromImages(image, index)">
                    <template v-slot:loading>
                      <q-spinner-facebook/>
                    </template>
                  </q-btn>
                  <q-img :src="image"/>
                </div>
              </div>
            </div>
            <div class="col-4">
              <q-uploader ref="multipleUploader"
                label="Images List (Restricted to images)"
                accept=".jpg, image/*"
                hide-upload-btn
                multiple square color="grey-10"
                @added="toggleImagesData($event, true, 'images')"
                @removed="toggleImagesData($event, false, 'images')"
              />
            </div>

          </div>

          <div class="column">
            <q-toggle v-model="directActive" label="Check to instantly publish product on catalog. (Not recommended)"
                      color="purple-9"/>
            <div>
              <q-btn :loading="loading" color="purple-10" label="Submit" type="submit" icon-right="send">
                <template v-slot:loading>
                  <q-spinner-hourglass class="on-left"/>
                  Loading...
                </template>
              </q-btn>
              <q-btn label="Cancel" @click="showEdit = false" color="black" flat class="q-ml-sm"/>
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

    import bus from '../../../utils/bus.js'


    export default {
        name: "EditModal",
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
                productToEdit: null,

                loading: false,

                name: '',
                price: null,
                description: '',
                brandSelected: null,
                colors: [],
                sizes: [],
                directActive: false,

                currentImages: [],
                currentImage: null,

                imageToUpload: null,
                imgIncrTemp: 0,
                imagesToUpload: [],

                loadingImage: false,
                loadingImages: false,

                imageToUploadLoading: false,
            }
        },
        mounted() {
            this.$root.$on('showEditProduct', (show, product) => {
                this.productToEdit = product
                this.brandSelected = product.brand_id
                this.name = product.name
                this.description = product.description
                this.price = product.price
                this.colors = product.colors
                this.sizes = product.sizes
                this.directActive = product.active === 1

                this.currentImage = product.image
                this.currentImages = product.images

                this.imageToUpload = null
                this.imagesToUpload = null

                this.showEdit = !!show
            })
        },
        watch: {
            imageToUpload(val) {
                if (val) {
                    this.addImage(val)
                }
            },
            imagesToUpload(val) {
                if (val) {
                    this.addImages(val)
                }
            }
        },
        computed: {
        },
        methods: {
            toggleImagesData(files, added, imageOrImages) {
                if (imageOrImages === 'image') {
                    this.imageToUpload = added ? files[0] : null
                } else if (imageOrImages === 'images') {
                    console.log(files)
                    if (added) {
                        this.imagesToUpload = files
                    }
                    console.log(this.imagesToUpload)
                }
            },

            validResponse() {
                this.showEdit = false
                this.name = ''
                this.description = ''
                this.currentImage = null
                this.currentImages = []
                bus.$emit('refreshProducts')
                this.loading = false
            },

            removeFromImage() {
                this.loadingImage = true
                this.$axios.delete(`/api/admin/products/imageDelete/${this.productToEdit.id}`)
                    .then(response => {
                        console.log(response);
                        this.loadingImage = false
                        this.currentImage = null
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingImage = false
                    })
            },
            removeFromImages(imgUrl, index) {
                this.loadingImages = index

                let newImages = this.currentImages.filter(url => url !== imgUrl)

                console.log(newImages)

                this.$axios.delete(`/api/admin/products/imagesDelete/${this.productToEdit.id}`, {data:{imgUrl: imgUrl, imagesArray: JSON.stringify(newImages)}})
                    .then(response => {
                        console.log(response);
                        this.loadingImages = false
                        this.currentImages = response.data.images
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingImages = false
                    })
            },
            addImage(image) {
                this.imageToUploadLoading = true

                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                formData.append('image', image)
                this.$axios.post(`/api/admin/products/addMainImage/${this.productToEdit.id}`, formData, config)
                    .then(response => {
                        console.log(response);
                        this.currentImage = response.data.image
                        this.imageToUploadLoading = false
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            addImages(images) {
                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                images.forEach(image => {
                    formData.append('images[]', image)
                })
                this.$axios.post(`/api/admin/products/addSecondImages/${this.productToEdit.id}`, formData, config)
                    .then(response => {
                        console.log(response);
                        this.currentImages = response.data.images
                        this.$refs.multipleUploader.reset()
                        this.imagesToUpload = null
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },

            editProduct() {
                this.loading = true

                this.$axios.post(`/api/admin/products/updateProduct/${this.productToEdit.id}`, {
                    name: this.name,
                    description: this.description,
                    price: this.price,
                    colors: JSON.stringify(this.colors),
                    sizes: JSON.stringify(this.sizes),
                    brandId: this.brandSelected
                })
                    .then(response => {
                        console.log(response);
                        this.validResponse()
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
    }
</script>

<style scoped lang="scss">
  .listSizesContainer {
    border: solid 1px #eeeeee;
  }

  .deleteBtn {
    position: absolute;
    z-index: 10;
    top: -2%;
    right: -2%;
  }
  .deleteBtnImages {
    position: absolute;
    z-index: 10;
    top: 4%;
    right: -4%;
  }
</style>

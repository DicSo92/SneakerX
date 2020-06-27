<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 1100px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="addProduct"
          class="q-gutter-md"
        >
          <div class="row">
            <div class="col-3" v-if="!image">
              <q-img
                src="http://res.cloudinary.com/charly-luzzi/image/upload/v1589846305/SneakerX/Products/Adidas/superstar-originals/knn2rqqaqdbczodbjvwp.jpg"
                style="width: 100%; height: auto"
              />
            </div>
            <q-uploader
              v-else square color="grey-10"
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
                    <q-icon name="euro_symbol" />
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

          <div class="flex justify-between">
            <q-uploader
              label="Images List (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              multiple square color="grey-10"
              @added="toggleImagesData($event, true, 'banner')"
              @removed="toggleImagesData($event, false, 'banner')"
              class="full-width" style="min-height: 300px"
            />
          </div>

          <div class="column">
            <q-toggle v-model="directActive" label="Check to instantly publish product on catalog. (Not recommended)" color="purple-9"/>
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

                name: '',
                price: null,
                description: '',
                brandSelected: null,
                colors: [],
                sizes: [],
                directActive: false,

                image: null,
                images: null,

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
            toggleImagesData(files, added, imageOrImages) {
                if (imageOrImages === 'image') {
                    this.image = added ? files[0] : null
                } else if (imageOrImages === 'images') {
                    this.images = added ? files[0] : null
                }
            },
            addProduct() {
                this.loading = true
                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                formData.append('name', this.name)
                formData.append('brandId', this.brandSelected)
                formData.append('description', this.description)
                formData.append('colors', this.colors)
                formData.append('sizes', this.sizes)
                formData.append('active', this.directActive)
                if (this.image) formData.append('banner', this.image)
                if (this.images) formData.append('image', this.images)

                this.$axios.post('/api/admin/products', formData, config)
                    .then(response => {
                        console.log(response);
                        this.showEdit = false
                        this.name = ''
                        this.description = ''
                        this.image = null
                        this.images = null
                        // bus.$emit('refreshProducts')
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false
                    })
            },
        },
    }
</script>

<style scoped lang="scss">
  .listSizesContainer {
    border: solid 1px #eeeeee;
  }
</style>

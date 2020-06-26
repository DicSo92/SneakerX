<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section>
        <q-form
          @submit="editBrand"
          class="q-gutter-md"
        >
          <q-input
            filled
            v-model="name"
            label="Brand Name *"
            hint="Main Name"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Please type something']"
          />

          <q-editor v-model="description" min-height="5rem" toolbar-toggle-color="yellow-9"/>

          <div class="row">
            <div class="col">
              <p>Current Banner : <span v-if="!currentBanner" class="text-red-8">Nothing</span></p>
              <div class="flex flex-center relative-position" v-if="currentBanner">
                <q-btn round :loading="loadingBanner" color="red-9" size='md' icon="delete" class="deleteBtn" @click="removeImage('banner')">
                  <template v-slot:loading>
                    <q-spinner-facebook />
                  </template>
                </q-btn>
                <q-img :src="currentBanner" alt="" class="currentImages"/>
              </div>
            </div>
            <div class="col">
              <p>Current Image : <span v-if="!currentImage" class="text-red-8">Nothing</span></p>
              <div class="flex flex-center relative-position" v-if="currentImage">
                <q-btn round :loading="loadingImage" color="red-9" size='md' icon="delete" class="deleteBtn" @click="removeImage('image')">
                  <template v-slot:loading>
                    <q-spinner-facebook />
                  </template>
                </q-btn>
                <q-img :src="currentImage" alt="" class="currentImages"/>
              </div>
            </div>
          </div>
          <div class="flex justify-between">
            <q-uploader
              label="Change Banner (.jpg,.png,.jpeg,...)"
              accept=".jpg, image/*"
              hide-upload-btn square color="grey-10"
              @added="toggleImagesData($event, true, 'banner')"
              @removed="toggleImagesData($event, false, 'banner')"

            />
            <q-uploader
              label="Change Image (.jpg,.png,.jpeg,...)"
              accept=".jpg, image/*"
              hide-upload-btn square color="grey-10"
              @added="toggleImagesData($event, true, 'image')"
              @removed="toggleImagesData($event, false, 'image')"
            />
          </div>


          <div>
            <q-btn :loading="loading" color="purple-10" label="Submit" type="submit" icon-right="send">
              <template v-slot:loading>
                <q-spinner-hourglass class="on-left"/>
                Loading...
              </template>
            </q-btn>
            <q-btn label="Cancel" @click="showEdit = false" color="black" flat class="q-ml-sm"/>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
    import bus from '../../../utils/bus.js'

    export default {
        name: "AddModal",
        data() {
            return {
                showEdit: false,
                brandToEdit: null,

                name: '',
                description: '',
                bannerFile: null,
                imageFile: null,

                currentBanner: null,
                currentImage: null,

                loadingBanner: false,
                loadingImage: false,
                loading: false
            }
        },
        mounted() {
            this.$root.$on('showEditBrand', (show, brand) => {
                this.brandToEdit = brand
                this.name = brand.name
                this.description = brand.description
                this.bannerFile = null
                this.imageFile = null
                this.currentBanner = brand.banner
                this.currentImage = brand.image
                this.showEdit = !!show
            })
        },
        methods: {
            editBrand() {
                this.loading = true
                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                if (this.name !== this.brandToEdit.name) formData.append('name', this.name)
                if (this.description !== this.brandToEdit.description) formData.append('description', this.description)

                if (this.bannerFile) formData.append('banner', this.bannerFile)
                if (this.imageFile) formData.append('image', this.imageFile)

                this.$axios.post(`/api/admin/brands/${this.brandToEdit.id}`, formData, config )
                    .then(response => {
                        console.log(response);
                        this.loading = false
                        this.showEdit = false
                        bus.$emit('refreshBrands')
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false
                    })
            },
            removeImage(type) {
                if (type === 'banner') this.loadingBanner = true
                if (type === 'image') this.loadingImage = true
                this.$axios.delete(`/api/admin/brands/imageDelete/${this.brandToEdit.id}?type=${type}`)
                    .then(response => {
                        console.log(response);
                        if (type === 'banner') {
                            this.loadingBanner = false
                            this.currentBanner = null
                        } else if (type === 'image') {
                            this.loadingImage = false
                            this.currentImage = null
                        }
                        bus.$emit('refreshBrands')
                    })
                    .catch(error => {
                        console.log(error);
                        if (type === 'banner') this.loadingBanner = false
                        if (type === 'image') this.loadingImage = false
                    })
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
  .currentImages {
    width: 75%;
  }
  .deleteBtn {
    position: absolute;
    z-index: 10;
    top: -8%;
    right: 8%;
  }
</style>

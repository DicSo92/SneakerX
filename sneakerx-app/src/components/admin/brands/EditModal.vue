<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section>
        <q-form
          @submit="addBrand"
          @reset=""
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

          <q-input
            v-model="description"
            label="Brand Description *"
            filled
            autogrow
          />

          <div class="row">
            <div class="col">
              <p>Current Banner : <span v-if="!currentBanner" class="text-red-8">Nothing</span></p>
              <div class="flex flex-center">
                <q-img v-if="currentBanner" :src="currentBanner" alt="" class="currentImages"/>
              </div>
            </div>
            <div class="col">
              <p>Current Image : <span v-if="!currentImage" class="text-red-8">Nothing</span></p>
              <div class="flex flex-center">
                <q-img v-if="currentImage" :src="currentImage" alt="" class="currentImages"/>
              </div>
            </div>
          </div>
          <div class="flex justify-between">
            <q-uploader
              label="Change Banner (.jpg,.png,.jpeg,...)"
              accept=".jpg, image/*"
              hide-upload-btn
              @added="toggleImagesData($event, true, 'banner')"
              @removed="toggleImagesData($event, false, 'banner')"

            />
            <q-uploader
              label="Change Image (.jpg,.png,.jpeg,...)"
              accept=".jpg, image/*"
              hide-upload-btn
              @added="toggleImagesData($event, true, 'image')"
              @removed="toggleImagesData($event, false, 'image')"
            />
          </div>


          <div>
            <q-btn :loading="loading" color="primary" label="Submit" type="submit" icon-right="send">
              <template v-slot:loading>
                <q-spinner-hourglass class="on-left"/>
                Loading...
              </template>
            </q-btn>
            <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm"/>
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
                name: '',
                description: '',
                bannerFile: null,
                imageFile: null,

                currentBanner: null,
                currentImage: null,

                loading: false
            }
        },
        mounted() {
            bus.$on('showEditModalBrand', (show, brand) => {
                this.name = brand.name
                this.description = brand.description
                this.currentBanner = brand.banner
                this.currentImage = brand.image
                this.showEdit = !!show
            })
        },
        methods: {
            addBrand() {

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
</style>

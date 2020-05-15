<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section>
        <q-form
          @submit="addBrand"
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

          <q-editor v-model="description" min-height="5rem" />

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


          <div>
            <q-btn :loading="loading" color="primary" label="Submit" type="submit" icon-right="send">
              <template v-slot:loading>
                <q-spinner-hourglass class="on-left" />
                Loading...
              </template>
            </q-btn>
            <q-btn label="Cancel" @click="showEdit = false" color="primary" flat class="q-ml-sm"/>

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
        data () {
            return {
                showEdit: false,
                name: '',
                description: '',
                bannerFile: null,
                imageFile: null,

                loading: false
            }
        },
        mounted() {
            this.$root.$on('showAddBrand', show => {
                this.showEdit = !!show
            })
        },
        methods: {
            addBrand() {
                this.loading = true
                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                formData.append('name', this.name)
                formData.append('description', this.description)
                if (this.bannerFile) formData.append('banner', this.bannerFile)
                if (this.imageFile) formData.append('image', this.imageFile)

                this.$axios.post('/api/admin/brands', formData, config)
                    .then(response => {
                        console.log(response);
                        this.showEdit = false
                        this.name = ''
                        this.description = ''
                        this.bannerFile = null
                        this.imageFile = null
                        bus.$emit('refreshBrands')
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false
                    })
            },
            toggleImagesData (files, added, qFor) {
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

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

<!--          &lt;!&ndash; Due to browser security policy, we can only read the value, but not write to it, so we only have an @input listener &ndash;&gt;-->
<!--          <q-input-->
<!--            @input="val => { bannerFile = val[0] }"-->
<!--            filled-->
<!--            type="file"-->
<!--            hint="Native file, .png, .jpg, .gif, 200x300"-->
<!--          />-->
<!--          <q-input-->
<!--            @input="val => { imageFile = val[0] }"-->
<!--            filled-->
<!--            type="file"-->
<!--            hint="Native file, .png, .jpg, .gif, 200x300"-->
<!--          />-->

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
            <q-btn label="Submit" type="submit" color="primary"/>
            <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
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
            }
        },
        mounted() {
            bus.$on('showAddModalBrand', show => {
                this.showEdit = !!show
            })
        },
        methods: {
            addBrand() {
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
                        bus.$emit('addBrandSuccess')
                    })
                    .catch(error => {
                        console.log(error);
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

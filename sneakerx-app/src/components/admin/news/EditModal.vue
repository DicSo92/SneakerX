<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 900px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="editActuality"
          class="q-gutter-md"
        >
          <div class="row">
            <div class="col-3 flex justify-center items-start relative-position" v-if="currentImage">
              <q-btn round :loading="loadingImage" color="red-9" size='md' icon="delete" class="deleteBtn"
                     @click="removeImage">
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
              hide-upload-btn
              class="col-auto" :disable="imageFileLoading"
              @added="toggleImagesData($event, true)"
              @removed="toggleImagesData($event, false)"
            />
            <div class="col q-px-md column">
              <div class="row items-start q-col-gutter-md">
                <q-input filled v-model="title" label="Actuality Title *"
                         class="col-6"
                         hint="Main Title"
                         lazy-rules color="purple-10"
                         :rules="[ val => val && val.length > 0 || 'Please type something']"
                />
                <q-input filled bottom-slots v-model="subtitle" label="Actuality Subtitle *"
                         hint="Subtitle"
                         class="col-6"
                         lazy-rules color="purple-10"
                         :rules="[ val => val && val.length > 0 || 'Please type something']">
                </q-input>
              </div>
              <q-input filled v-model="refLink" label="Ref. Link"
                       hint="Ref. Link"
                       color="purple-10" class="q-mt-md"/>
            </div>
          </div>

          <q-editor v-model="content" min-height="10rem" toolbar-toggle-color="yellow-9"/>

          <div class="column">
            <q-toggle v-model="published" label="Check to instantly publish this actuality on website. (Not recommended)" color="purple-9"/>
            <div>
              <q-btn :loading="loading" color="purple-10" label="Submit" type="submit" icon-right="send">
                <template v-slot:loading>
                  <q-spinner-hourglass class="on-left" />
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
    import bus from '../../../utils/bus.js'

    export default {
        name: "EditModal",
        data () {
            return {
                showEdit: false,
                title: '',
                subtitle: '',
                content: '',
                published: false,
                refLink: '',
                imageFile: null,

                currentImage: null,
                actualityToEdit: null,

                imageFileLoading: false,
                loadingImage: false,
                loading: false,
            }
        },
        watch: {
            imageFile(val) {
                if (val) {
                    this.addImage(val)
                }
            },
        },
        mounted() {
            this.$root.$on('showEditActuality', (show, actuality) => {
                this.actualityToEdit = actuality
                this.title = actuality.title
                this.subtitle = actuality.subtitle
                this.content = actuality.content
                this.refLink = actuality.refLink
                this.published = actuality.published === 1
                this.currentImage = actuality.image

                this.imageFile = null
                this.showEdit = !!show
            })
        },
        methods: {
            addImage(image) {
                this.imageFileLoading = true

                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                formData.append('image', image)
                this.$axios.post(`/api/admin/news/addImage/${this.actualityToEdit.id}`, formData, config)
                    .then(response => {
                        console.log(response);
                        this.currentImage = response.data.image
                        this.imageFileLoading = false
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            removeImage() {
                this.loadingImage = true
                this.$axios.delete(`/api/admin/news/imageDelete/${this.actualityToEdit.id}`)
                    .then(response => {
                        console.log(response);
                        this.loadingImage = false
                        this.currentImage = null
                        bus.$emit('refreshNews')
                    })
                    .catch(error => {
                        console.log(error);
                        this.loadingImage = false
                    })
            },
            editActuality() {
                this.loading = true

                this.$axios.post(`/api/admin/news/updateActuality/${this.actualityToEdit.id}`, {
                    title: this.title,
                    subtitle: this.subtitle,
                    content: this.content,
                    refLink: this.refLink,
                    published : JSON.stringify(this.published),
                })
                    .then(response => {
                        console.log(response);
                        this.validResponse()
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            toggleImagesData (files, added) {
                this.imageFile = added ? files[0] : null
            },
            validResponse() {
                this.showEdit = false
                this.title = ''
                this.subtitle = ''
                this.content = ''
                this.refLink = ''
                this.currentImage = null
                bus.$emit('refreshNews')
                this.loading = false
            },
        },
    }
</script>

<style scoped lang="scss">
  .deleteBtn {
    position: absolute;
    z-index: 10;
    top: -4%;
    right: -4%;
  }
</style>

<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 900px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="addActuality"
          class="q-gutter-md"
        >
          <div class="row">
            <q-uploader
              square color="grey-10"
              label="Main Image (Restricted to images)"
              accept=".jpg, image/*"
              hide-upload-btn
              class="col-auto"
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
        name: "AddModal",
        data () {
            return {
                showEdit: false,
                title: '',
                subtitle: '',
                content: '',
                published: false,
                refLink: '',

                imageFile: null,

                loading: false,
            }
        },
        mounted() {
            this.$root.$on('showAddActuality', show => {
                this.showEdit = !!show
            })
        },
        methods: {
            addActuality() {
                this.loading = true
                const config = { headers: {'content-type': 'multipart/form-data'} }

                let formData = new FormData()
                formData.append('title', this.title)
                formData.append('subtitle', this.subtitle)
                formData.append('content', this.content)
                formData.append('published', this.published)
                if (this.refLink && this.refLink.length > 0) formData.append('refLink', this.refLink)
                if (this.imageFile) formData.append('image', this.imageFile)

                this.$axios.post('/api/admin/news', formData, config)
                    .then(response => {
                        console.log(response);
                        this.showEdit = false
                        this.title = ''
                        this.subtitle = ''
                        this.content = ''
                        this.refLink = ''
                        this.imageFile = null
                        bus.$emit('refreshNews')
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false
                    })
            },
            toggleImagesData (files, added) {
                this.imageFile = added ? files[0] : null
            }
        },
    }
</script>

<style scoped>

</style>

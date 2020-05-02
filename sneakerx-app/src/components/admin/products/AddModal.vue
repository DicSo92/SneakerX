<template>
  <q-dialog v-model="showEdit">
    <q-card style="width: 1100px; max-width: 90vw;">
      <q-card-section>
        <q-form
          @submit="addBrand"
          class="q-gutter-md"
        >
          <div class="row">
            <q-avatar rounded size="200px" class="col-auto">
              <img src="http://res.cloudinary.com/charly-luzzi/image/upload/v1588357094/SneakerX/Products/Adidas/superstar-originals/e5k42tybhaxhnx6tkjrr.jpg">
            </q-avatar>
            <div class="col q-px-md column ">
              <q-input filled v-model="name" label="Brand Name *"
                       hint="Main Name"
                       lazy-rules
                       :rules="[ val => val && val.length > 0 || 'Please type something']"
              />
              <q-select color="purple-12"
                        v-model="modelBrand"
                        :options="brands"
                        option-value="id"
                        option-label="name"
                        option-disable="inactive"
                        emit-value
                        map-options
                        label="Select Brand">
                <template v-slot:prepend>
                  <q-icon name="event" />
                </template>
              </q-select>
            </div>
          </div>

          <q-editor v-model="description" min-height="8rem" />

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
    export default {
        name: "AddModal",
        props: [
            'brands'
        ],
        data () {
            return {
                showEdit: false,
                name: '',
                description: '',
                bannerFile: null,
                imageFile: null,

                loading: false,


                modelBrand: null
            }
        },
        mounted() {
            this.$root.$on('showAddProduct', show => {
                this.showEdit = !!show
            })
        },
        methods: {
            addBrand() {
                console.log('Fake Submit');
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

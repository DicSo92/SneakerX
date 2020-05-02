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
                <div class="column col-6">
                  <div class="flex q-mb-sm">
                    <q-icon name="colorize" size="sm" color="purple"/>
                    <div class="text-subtitle2 q-ml-xs">Colors* :</div>
                    <div class="text-caption text-negative q-ml-sm" v-if="!colors.length">No colors selected*</div>
                    <q-space/>
                    <!--                    <q-btn dense rounded no-caps size="md"-->
                    <!--                           icon="add" glossy color="deep-orange"-->
                    <!--                           @click="addInputColor"-->
                    <!--                    />-->
                  </div>
                  <!--                  <q-list bordered dense class="q-mb-sm">-->
                  <draggable
                    class="q-mb-sm no-padding"
                    tag="div"
                    v-model="colors"
                    v-bind="dragOptions"
                    @start="drag = true"
                    @end="drag = false"
                  >
                    <transition-group type="transition" :name="!drag ? 'flip-list' : null">

                      <q-item dense v-for="(color, index) in colors" :key="color.color"
                              class="colorItem">
                        <q-item-section avatar>
                          <div class="q-mr-sm" style="width: 20px; height: 20px"
                               :style="{backgroundColor: color.color}"></div>
                        </q-item-section>
                        <q-item-section>
                          <div class="flex full-width justify-between">
                            <div>{{color.name}}</div>
                            <div class="text-caption" :class="color.available ? 'text-positive' : 'text-negative'">
                              {{color.available ? 'Available' : 'Unavailable'}}
                            </div>
                          </div>
                        </q-item-section>
                        <q-item-section side>
                          <q-btn round size="xs" color="negative" icon="clear" @click="removeColor(index)"/>
                        </q-item-section>
                      </q-item>
                    </transition-group>
                  </draggable>

                  <div class="row q-gutter-sm items-start">
                    <q-input filled v-model="inputColor.name" label="Color Name *"
                             dense
                             class="col"
                             hint="Color Name for catalog"
                             @keydown.enter.prevent="addColor"
                             :rules="[val => validateColorInput.value || validateColorInput.message]"
                    />
                    <q-separator vertical/>
                    <div class="column col-auto" style="margin-top: 12px">
                      <div class="flex">
                        <div class="q-pa-md q-mr-sm" :style="{backgroundColor: inputColor.color}"></div>
                        <q-btn dense no-caps size="md" icon-right="colorize" glossy color="teal">
                          <q-popup-proxy transition-show="scale" transition-hide="scale">
                            <q-color v-model="inputColor.color"/>
                          </q-popup-proxy>
                        </q-btn>
                      </div>
                      <q-btn dense no-caps size="sm"
                             icon="save" color="primary"
                             class="q-mt-sm"
                             @click="addColor" :disabled="inputColor.name.length === 0 || !validateColorInput.value"/>
                    </div>
                  </div>
                </div>
                <q-separator vertical class="q-mx-md"/>
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

    export default {
        name: "AddModal",
        props: [
            'brands'
        ],
        components: {
            draggable
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

                inputColor: {
                    name: '',
                    color: '#B33636',
                    available: true,
                },
                colors: [],
                drag: false
                // [ {name: ..., color: ..., available: true}]
            }
        },
        mounted() {
            this.$root.$on('showAddProduct', show => {
                this.showEdit = !!show
            })
        },
        watch: {
            inputColor(val) {
            }
        },
        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            },
            validateColorInput() {
                if (this.inputColor.name.length > 0 && this.colors.find(el => el.name === this.inputColor.name)) {
                    return {value: false, message: 'This name is already taken'}
                } else if (this.inputColor.name.length > 0 && this.colors.find(el => el.color === this.inputColor.color)) {
                    return {value: false, message: 'This color is already taken'}
                } else {
                    return {value: true, message: ''}
                }
            }
        },
        methods: {
            removeColor(index) {
                this.colors.splice(index, 1)
            },
            addInputColor() {

            },
            addColor() {
                if (this.inputColor.name.length > 0 && this.validateColorInput.value) {
                    this.colors.push(this.inputColor)
                    this.inputColor = {
                        name: '',
                        color: '#' + (Math.random() * 0xFFFFFF << 0).toString(16),
                        available: true,
                    }
                } else {
                    console.log('error')
                }
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
  .no-move {
    transition: transform 0s;
  }
  .ghost {
    opacity: 0.7;
    background: #c8ebfb;
  }
  .flip-list-move {
    transition: all 0.5s;
  }

  .flip-list-enter, .flip-list-leave-to {
    opacity: 0;
    transform: translateX(-50px);
  }
  .flip-list-leave-active {
    position: absolute;
    /*z-index: 10;*/
  }


  .colorItem {
    cursor: move !important;
  }
</style>

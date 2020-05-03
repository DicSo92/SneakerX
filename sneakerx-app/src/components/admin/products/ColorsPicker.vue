<template>
  <div class="column">
    <div class="flex q-mb-sm q-pb-sm" style="border-bottom: solid 1px #eeeeee;">
      <q-icon name="colorize" size="sm" color="purple"/>
      <div class="text-subtitle2 q-ml-xs">Colors* :</div>
      <div class="text-caption text-negative q-ml-sm" v-if="!colors.length">No colors selected*</div>
      <q-space/>
      <!--                    <q-btn dense rounded no-caps size="md"-->
      <!--                           icon="add" glossy color="deep-orange"-->
      <!--                           @click="addInputColor"-->
      <!--                    />-->
    </div>

    <div class="row q-gutter-sm items-start q-mb-sm">
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

    <draggable
      class="no-padding listContainer"
      tag="div"
      handle=".handle"
      v-model="colors"
      v-bind="dragOptions"
      @start="drag = true"
      @end="drag = false"
      v-if="colors.length"
    >
      <transition-group type="transition" :name="!drag ? 'flip-list' : null">

        <q-item dense v-for="(color, index) in colors" :key="color.color">
          <q-item-section avatar>
            <div class="flex items-center justify-start">
              <q-icon size="sm" name="drag_indicator" class="handle q-mr-sm"/>
              <div class="q-mr-sm" style="width: 20px; height: 20px"
                   :style="{backgroundColor: color.color}">
              </div>
            </div>
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
            <q-btn dense round size="xs" color="negative" icon="clear" @click="removeColor(index)"/>
          </q-item-section>
        </q-item>
      </transition-group>
    </draggable>
  </div>
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        name: "ColorsPicker",
        props: [
            'colorsProps'
        ],
        components: {
            draggable,
        },
        data() {
            return {
                colors: this.colorsProps,
                inputColor: {
                    name: '',
                    color: '#B33636',
                    available: true,
                },
                drag: false,
            }
        },
        watch: {
            colors(val) {
                this.$emit('colorsChange', val)
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


  .handle {
    cursor: move;
  }
  .listContainer {
    border: solid 1px #eeeeee;
  }
</style>

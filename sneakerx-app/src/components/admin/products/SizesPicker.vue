<template>
  <div class="column">
    <div class="flex q-mb-sm q-pb-sm" style="border-bottom: solid 1px #eeeeee;">
      <q-icon name="colorize" size="sm" color="purple"/>
      <div class="text-subtitle2 q-ml-xs">Sizes* :</div>
      <div class="text-caption text-negative q-ml-sm" v-if="!sizesAsc.length">No sizes selected*</div>
      <q-space/>
    </div>
    <q-select
      filled
      dense
      v-model="sizes"
      multiple
      :options="sizeOptions"
      option-label="size"
      label="Choose Sizes"
      counter
      hint="Counter Sizes"
      class="full-width q-mb-md">

      <template v-if="sizes.length" v-slot:append>
        <q-icon name="cancel" @click.stop="sizes = []" class="cursor-pointer"/>
      </template>
    </q-select>
    <div class="flex">
      <q-chip v-for="(size, index) in sizesAsc" :key="size.size"
              dense
              removable
              clickable
              :color="size.available ? 'green-6' : 'red-7'"
              :selected.sync="sizes[index].available"
              class="text-bold"
              text-color="white"
              icon="warning"
              @remove="sizes.splice(index, 1)">
        <!--                      <q-avatar color="red" text-color="white">{{size.size}}</q-avatar>-->
        {{size.size}}
      </q-chip>
    </div>
  </div>
</template>

<script>
    export default {
        name: "SizesPicker",
        props: [
            'sizesProps'
        ],
        data() {
            return {
                sizes: this.sizesProps,
                sizeOptions: [{size: 34, available: true}, {size: 35, available: true}, {size: 36, available: true}, {size: 37, available: true}, {size: 38, available: true}, {size: 39, available: true}, {size: 40, available: true}, {size: 41, available: true}, {size: 42, available: true}, {size: 43, available: true}, {size: 44, available: true}, {size: 45, available: true}, {size: 46, available: true}, {size: 47, available: true}, {size: 48, available: true}, {size: 49, available: true}, {size: 50, available: true}, {size: 51, available: true}, {size: 52, available: true}]
            }
        },
        watch: {
            sizes(val) {
                this.$emit('sizesChange', val)
            }
        },
        computed: {
            sizesAsc() {
                return this.sizes.sort(this.sizesAscComparison)
            }
        },
        methods: {
            sizesAscComparison(a, b) {
                let comparison = 0;
                if (a.size > b.size) {
                    comparison = 1;
                } else if (a.size < b.size) {
                    comparison = -1;
                }
                return comparison;
            },
        },
    }
</script>

<style scoped>

</style>

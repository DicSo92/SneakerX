<template>
  <q-form @submit="addBrand" class="q-gutter-md flex flex-center">
    <q-input
      name="name"
      v-model="newBrand"
      color="primary"
      label="New Brand..."
      filled
      clearable
    />

    <div>
      <q-btn label="Submit" type="submit" color="primary"/>
    </div>
  </q-form>
</template>

<script>
    import bus from '../../../utils/bus.js'

    export default {
        name: "AddBrand",
        data () {
            return {
                newBrand: ''
            }
        },
        created() {
        },
        mounted() {
        },
        computed: {

        },
        methods: {
            addBrand () {
                console.log(this.newBrand)
                bus.$emit('showAddModalBrand', true)
            }
        }
    }
</script>

<style scoped>

</style>

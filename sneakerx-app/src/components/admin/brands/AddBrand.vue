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
            }
        }
    }
</script>

<style scoped>

</style>

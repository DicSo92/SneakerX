<template>
    <div class="addBrand q-my-md">
      <q-btn label="New Brand" @click="addBrand" color="primary"/>
    </div>
</template>

<script>
    import bus from '../../../utils/bus.js'

    export default {
        name: "AddBrand",
        data () {
            return {

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
                bus.$emit('showAddModalBrand', true)
            }
        }
    }
</script>

<style scoped>

</style>

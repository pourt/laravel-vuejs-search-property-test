<template>
   <search-property></search-property>
</template>

<script>
    import SearchPropertyComponent from './property/SearchProperty.vue'

    export default {
        components : {
            'search-property': SearchPropertyComponent
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

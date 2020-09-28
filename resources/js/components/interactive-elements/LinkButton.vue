<template>
    <a 
        :href="href"
        class="btn interactive-element" 
        :style="styles">{{title}}</a>
</template>

<script>
    export default {
        props: {
            href: {
                type: String
            },
            styles:{
                type: Object
            },
            title: {
                type: String
            },
            type: {
                type: String,
                default: () => 'link'
            }
        },
        watch: {
            
        }
    }
</script>
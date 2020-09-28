<template>
    <a 
        v-if="type == 'link'"
        :href="href"
        class="btn interactive-element" 
        :style="styles"><slot></slot></a>

    <!-- <button 
        v-else-if="elem == 'button'"
        :href="href"
        class="btn interactive-element" 
        :style="styles">{{title}}</button> -->

</template>
<script>
    
    export default {
        props: {
            type: {
                type: String,
                // validator(value) {

                // }
            },
            href: {
                type: String
            },
            styles: {
                type: Object
            }
        }
    }
</script>
<template>
    <div>
        <a 
            v-if="type == 'link'"
            :href="href"
            class="btn interactive-element" 
            :style="styles"><slot></slot></a>

        <div 
            v-if="type == 'text'"
            class="interactive-element"
            :style="styles">
            <slot></slot>
        </div>

        <!-- <button 
            v-else-if="elem == 'button'"
            :href="href"
            class="btn interactive-element" 
            :style="styles">{{title}}</button> -->
    </div>

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
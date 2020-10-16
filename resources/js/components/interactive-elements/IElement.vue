<template>
    <div>
        <a 
            v-if="type == 'link'"
            :href="href"
            class="btn interactive-element ie-fadeIn" 
            :class="{show: show}"
            :style="styles"><slot></slot></a>

        <div 
            v-if="type == 'text'"
            class="interactive-element"
            :class="{show: show}"
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
    import timeConv from '../../plugin/Date';
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
            },
            from: {
                type: String
            },
            to: {
                type: String
            },
            videoCurrentTime: {
                type: [String, Number]
            },
            isVideoPlaying: {
                type: Boolean,
                default: () => false
            },
            onEdit: {
                type: Boolean,
                default: () => false
            }
        },
        computed: {
            fromSec(){
                return timeConv.spanTimeToSeconds(this.from);
            },
            toSec(){
                return timeConv.spanTimeToSeconds(this.to);
            }
        },
        data(){
            return {
                show: false
            }
        },
        watch: {
            videoCurrentTime(nData, oData){
                // console.log('Video Current time from IE: '+parseFloat(nData).toFixed(2) +' - '+ nData);

                if(nData >= this.fromSec) {
                    this.setShow(true);
                }

                if (nData >= this.toSec){
                    this.setShow(false);
                }
            },
            onEdit(nData, oData) {
                if (nData){
                    this.setShow(true);
                }
            },
            isVideoPlaying(nData, oData){
                if (nData) {
                    this.setShow(false);
                }
            }
        },
        methods: {
            setShow(bol){
                this.show = bol;
            }
        },
    }
</script>
<style lang="scss" scoped>
    .interactive-element {
        display: none;
        &.show {
            display: block;
            
            &.ie-bounce{
                animation: bounce;
                animation-duration: 2s;
            }

            &.ie-fade-in{
                animation: fadeIn;
                animation-duration: 2s;
            }
        }

        &.ie-fade-out{
            animation: fadeOut;
            animation-duration: 2s;
        }
    }
</style>
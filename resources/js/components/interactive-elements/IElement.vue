<template>
    <div>
        <transition 
            :enter-active-class="animateClasses.enter" 
            :leave-active-class="animateClasses.leave">
            <a 
                v-if="type == 'link'"
                :href="href"
                class="btn interactive-element" 
                v-show="show"
                :style="mainStyle"><slot></slot></a>

            <div 
                v-if="type == 'text'"
                class="interactive-element ie-container"
                v-show="show"
                :style="mainStyle">
                <div class="bg" :style="bgStyle"></div>
                <div class="text-content">
                    <slot></slot>
                </div>
            </div>
        </transition>
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
            animateClasses: {
                type: Object
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
                show: false,
                mainStyle: {},
                bgStyle: {}
            }
        },
        watch: {
            styles: {
                handler(nData, oData) {
                    this.initStyles(nData);
                    switch(this.type){
                        case 'text':
                            this.bgStyle.opacity = nData.opacity;
                            this.bgStyle.backgroundColor = nData.backgroundColor;
                            
                            this.mainStyle = nData;
                            break;

                        default:
                            this.mainStyle = nData
                            break;
                    }
                },
                deep: true
            },
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
            },
            initStyles (styleObj) {
                switch(this.type){
                    case 'text':
                        this.bgStyle.opacity = styleObj.opacity;
                        this.bgStyle.backgroundColor = styleObj.backgroundColor;
                        
                        this.mainStyle = styleObj;
                        break;

                    default:
                        this.mainStyle = styleObj
                        break;
                }
            }
        },
        mounted() {
            this.initStyles(this.styles);

            if (this.onEdit) {
                this.setShow(true);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .interactive-element {
        overflow: hidden;

        &.ie-fade-enter-active {
            animation: fadeIn;
            animation-duration: 2s;
        }

        &.ie-fade-leave-active {
            animation: fadeOut;
            animation-duration: 2s;
        }

        &.ie-bounce-enter-active {
            animation: bounceIn;
            animation-duration: .5s;
        }

        &.ie-bounce-leave-active {
            animation: bounceOut;
            animation-duration: .5s;
        }

        &.ie-container {
            opacity: 1 !important;
            background-color: transparent !important;
            .bg {
                height: 100%;
                width: 100%;
                position: absolute;
                top: 0;
                left: 0;

                z-index: 1;
            }

            .text-content {
                padding: 0;
                position: relative;
                z-index: 9;
            }
        }
    }
</style>
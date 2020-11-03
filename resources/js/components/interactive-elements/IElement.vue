<template>
    <div>
        <transition 
            :enter-active-class="animateClasses.enter" 
            :leave-active-class="animateClasses.leave">
            <a 
                v-if="type == 'link'"
                :href="href"
                target="__blank"
                class="btn interactive-element" 
                v-show="show"
                :style="mainStyle"
                @click.prevent="doAction"><slot></slot></a>

            <div 
                v-if="type == 'text'"
                class="interactive-element ie-container"
                v-show="show"
                :style="mainStyle"
                @click="doAction">
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
            action: {
                type: [Number, String]
            },
            href: {
                type: String
            },
            linkTime: {
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

                if (nData <= this.fromSec){
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
            },
            doAction(){
                let action = parseInt(this.action);
                switch (action){
                    case 1:
                        window.open(this.href);
                        break;
                    case 2:
                        this.$emit('on-link-time', this.linkTime);
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
<template>
    <input 
        type="range" 
        class="aj-range-slider"
        id="ajRangeSlider"
        v-model="model"
        :min="min"
        :max="max">
</template>

<script>
    export default {
        props:{
            value: {
                type: Number
            },
            min:{
                type: Number,
                default(){
                    return 0;
                }
            },
            max:{
                type: Number,
                default(){
                    return 100;
                }
            },
            height: {
                type: String,
                default() {
                    return '15px'
                }
            },
            width: {
                type: String,
                default() {
                    return '100%'
                }
            },
            thumbStyle: {
                type: Object
            }
        },
        data() {
            return {
                model: 0
            }
        },
        methods: {
            onChange () {
                console.log(this.model)
            }
        },
        mounted(){
            if (this.value) this.model=this.value;
            let elem = document.getElementById('ajRangeSlider');
            elem.style.height = this.height;
            elem.style.width = this.width;

            if (this.thumbStyle) {
                el
            }

            elem.addEventListener('mousemove', this.onChange);
        }
    }
</script>

<style lang="scss">
    .aj-range-slider {
        -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
        width: 100%; /* Specific width is required for Firefox. */
        height: 15px;
        outline: none;
        background: rgba(0, 0, 0, .8); /* Otherwise white in Chrome */
        border-radius: 15px;
        box-shadow: 0 0 0 2px #151515, inset 0 0 5px #000;
        z-index: 2;
        overflow: hidden;

        &::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #e1c238;
            border: 3px solid #222;
            z-index: 2;
            box-shadow: -407px 0 0 400px #e1c238;
        }

        // &::-ms-track {
        //   width: 100%;
        //   cursor: pointer;
        
        //   /* Hides the slider so custom styles can be added */
        //   background: transparent; 
        //   border-color: transparent;
        //   color: transparent;
        // }

        // &::-webkit-slider-thumb {
        //   -webkit-appearance: none;
        //   border: 1px solid #000000;
        //   height: 36px;
        //   width: 16px;
        //   border-radius: 3px;
        //   background: #ffffff;
        //   cursor: pointer;
        //   margin-top: -14px; /* You need to specify a margin in Chrome, but in Firefox and IE it is automatic */
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d; /* Add cool effects to your sliders! */
        // }

        // &::-moz-range-thumb {
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        //   border: 1px solid #000000;
        //   height: 36px;
        //   width: 16px;
        //   border-radius: 3px;
        //   background: #ffffff;
        //   cursor: pointer;
        // }

        // &::-ms-thumb {
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        //   border: 1px solid #000000;
        //   height: 36px;
        //   width: 16px;
        //   border-radius: 3px;
        //   background: #ffffff;
        //   cursor: pointer;
        // }

        // &::-webkit-slider-runnable-track {
        //   width: 100%;
        //   height: 8.4px;
        //   cursor: pointer;
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        //   background: #3071a9;
        //   border-radius: 1.3px;
        //   border: 0.2px solid #010101;
        // }

        // &::-webkit-slider-runnable-track {
        //   background: #367ebd;
        // }

        // &::-moz-range-track {
        //   width: 100%;
        //   height: 8.4px;
        //   cursor: pointer;
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        //   background: #3071a9;
        //   border-radius: 1.3px;
        //   border: 0.2px solid #010101;
        // }

        // &::-ms-track {
        //   width: 100%;
        //   height: 8.4px;
        //   cursor: pointer;
        //   background: transparent;
        //   border-color: transparent;
        //   border-width: 16px 0;
        //   color: transparent;
        // }

        // &::-ms-fill-lower {
        //   background: #2a6495;
        //   border: 0.2px solid #010101;
        //   border-radius: 2.6px;
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        // }

        // &:focus {
        //   outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */

        //   &::-ms-fill-lower {
        //     background: #3071a9;
        //   }

        //   &::-ms-fill-upper {
        //     background: #367ebd;
        //   }
        // }

        // &::-ms-fill-upper {
        //   background: #3071a9;
        //   border: 0.2px solid #010101;
        //   border-radius: 2.6px;
        //   box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        // }


    }
</style>
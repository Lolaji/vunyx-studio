<template>
    <input 
        type="range" 
        id="ionRangeSlider">
</template>

<script>

    import '../../assets/plugins/ion-rangeslider/js/ion.rangeSlider';
    import '../../assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css';

    export default {
        props: {
            type: {
                type: String,
                default: () => 'single',
            },
            min: {
                type: [Number, String],
                default: () => 0
            },
            max: {
                type: [Number, String],
                default: () => 100
            },
            from: {
                type: [Number, String],
                default: () => 0
            },
            to: {
                type: [Number, String],
                default: () => 100
            },
            step: {
                type: [String, Number],
                default: () => 1
            },
            value: {
                type: [Number, Array],
            },
            keyboard: {
                type: Boolean,
                default: () => true
            },
            grid: {
                type: Boolean,
                default: () => false
            },
            gridNum: {
                type: [Number, String],
                default: () => 4
            },
            gridSnap: {
                type: Boolean,
                default: () => false
            },
            gridMargin: {
                type: Boolean,
                default: () => true
            },
            dragInterval: {
                type: Boolean,
                default: () => false
            },
            minInterval: {
                type: Number,
            },
            maxInterval: {
                type: Number,
            },
            
            fromFixed: {
                type: Boolean,
                default: () => false
            },
            fromMin: {
                type: Number
            },
            fromMax: {
                type: Number
            },
            fromShadow: {
                type: Boolean,
                default: () => false
            },
            toFixed: {
                type: Boolean,
                default: () => false
            },
            toMin: {
                type: Number
            },
            toMax: {
                type: Number
            },
            toShadow: {
                type: Boolean,
                default: () => false
            },

            skin: {
                type: String,
                default: () => "round",
                validator: function validator(val) {
                    return ['flat', 'big', 'modern', 'sharp', 'round', 'square'].indexOf(val) > -1;
                }
            },
            hideMinMax: {
                type: Boolean,
                default: () => false
            },
            hideFromTo: {
                type: Boolean,
                default: () => false,
            },
            forceEdges: {
                type: Boolean,
                default: () => false,
            },
            extraClasses: {
                type: String,
            },
            block: {
                type: Boolean,
                default: () => false
            },

            //Prettify numbers
            prettifyEnabled: {
                type: Boolean,
                default: () => false
            },
            prettifySeparator: {
                type: String,
                default: () => " "
            },
            prettify: {
                type: Function,
            },
            prefix: {
                type: String,
                // default: () => "—"
            },
            postfix: {
                type: String,
                // default: () => "—"
            },
            maxPostfix: {
                type: String,
                // default: () => "—"
            },
            decorateBoth: {
                type: Boolean,
                default: () => false
            },

            valuesSeparator: {
                type: String,
                default: () => " ; "
            },
            disable: {
                type: Boolean,
                default: () => false
            }
        },
        data(){
            return {
                sliderInstance: null,
            }
        },
        methods: {
            start(data) {
                this.$emit('start', data);
            },
            change(data){
                this.$emit('change', data);
            },
            update(data) {
                this.$emit('update', data);
            },
            finish(data){
                this.$emit('finish', data);
            }

        },
        mounted() {
            let slider = $(this.$el);

            slider.ionRangeSlider({
                type: this.type,
                min: this.min,
                max: this.max,
                from: this.from,
                to: this.to,

                // Advance setup
                value: this.value,
                step: this.step,
                keyboard: this.keyboard,

                // Grid Setup
                grid: this.grid,
                grid_num: this.gridNum,        // default 4 (set number of grid cells)
                grid_snap: this.gridSnap,
                grid_margin: this.gridMargin,

                //Interval Setup
                drag_interval: this.dragInterval,
                min_interval: this.minInterval,
                max_interval: this.maxInterval,

                //Handles control
                from_fixed: this.fromFixed,
                from_min: this.fromMin,
                from_max: this.fromMax,
                from_shadow: this.fromShadow,
                to_fixed: this.toFixed,
                to_min: this.toMin,
                to_max: this.toMax,
                to_shadow: this.toShadow,

                // UI Control
                skin: this.skin, // flat, big, modern, sharp, round, square
                hide_min_max: this.hideMinMax,
                hide_from_to: this.hideFromTo,
                force_edges: this.forceEdges,
                extra_classes: this.extraClasses,
                block: this.block,

                //Prettify numbers
                prettify_enabled: this.prettifyEnabled,
                prettify_separator: this.prettifySeparator,
                prettify: this.prettify,
                prefix: this.prefix,
                postfix: this.postfix,
                max_postfix: this.maxPostfix,
                decorate_both: this.decorateBoth,
                values_separator: this.valuesSeparator,

                //Data control
                input_values_separator: this.inputValuesSeparator,
                disable: this.disable,
                
                
                // Callbacks
                scope: this.scope,
                onStart: this.start,
                onChange: this.change,
                onUpdate: this.update,
                onFinish: this.finish,
            });

            this.sliderInstance =  slider.data('ionRangeSlider');

            this.$emit('ready', this.sliderInstance);
        }
    }
</script>
<style lang="scss">
    .irs--round {
        height: 50px;
    }
    .irs--round.irs-with-grid {
        height: 65px;
    }
    .irs--round .irs-line {
        top: 36px;
        height: 4px;
        background-color: #dee4ec;
        border-radius: 4px;
    }
    .irs--round .irs-bar {
        top: 36px;
        height: 4px;
        background-color: #e1c238;
    }
    .irs--round .irs-bar--single {
        border-radius: 4px 0 0 4px;
    }
    .irs--round .irs-shadow {
        height: 4px;
        bottom: 21px;
        background-color: rgba(222, 228, 236, 0.5);
    }
    .irs--round .irs-handle {
        top: 26px;
        width: 24px;
        height: 24px;
        border: 4px solid #e1c238;
        background-color: white;
        border-radius: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 255, 0.3);
    }
    .irs--round .irs-handle.state_hover,
    .irs--round .irs-handle:hover {
        background-color: #f0f6ff;
    }
    .irs--round .irs-min,
    .irs--round .irs-max {
        color: #333;
        font-size: 14px;
        line-height: 1;
        top: 0;
        padding: 3px 5px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }
    .irs--round .irs-from,
    .irs--round .irs-to,
    .irs--round .irs-single {
        font-size: 14px;
        line-height: 1;
        text-shadow: none;
        padding: 3px 5px;
        background-color: #e1c238;
        color: white;
        border-radius: 4px;
    }
    .irs--round .irs-from:before,
    .irs--round .irs-to:before,
    .irs--round .irs-single:before {
        position: absolute;
        display: block;
    content: "";
        bottom: -6px;
        left: 50%;
        width: 0;
        height: 0;
        margin-left: -3px;
        overflow: hidden;
        border: 3px solid transparent;
        border-top-color: #e1c238;
    }
    .irs--round .irs-grid {
        height: 25px;
    }
    .irs--round .irs-grid-pol {
        background-color: #dedede;
    }
    .irs--round .irs-grid-text {
        color: silver;
        font-size: 13px;
    }

    .main-footer {
        margin-top: 0;
    }
</style>
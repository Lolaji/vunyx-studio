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
            skin: {
                type: String,
                default: () => "round",
                validator: function validator(val) {
                    return ['flat', 'big', 'modern', 'sharp', 'round', 'square'].indexOf(val) > -1;
                }
            },
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
            step: {
                type: [String, Number],
                default: () => 1
            },
            hideFromTo: {
                type: Boolean,
                default: () => true,
            },
            grid: {
                type: Boolean,
                default: () => false
            },
            gridNum: {
                type: [Number, String],
                default: () => 6
            },
            gridSnap: {
                type: Boolean,
                default: () => false
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
            $(this.$el).ionRangeSlider({
                skin: this.skin, // flat, big, modern, sharp, round, square
                min: this.min,
                max: this.max,
                type: this.type,
                step: this.step,
                // hide_min_max: true,
                hide_from_to: this.hideFromTo,
                grid: this.grid,
                grid_num: this.gridNum,        // default 4 (set number of grid cells)
                grid_snap: this.gridSnap,

                
                // Events
                onStart: this.start,
                onChange: this.change,
                onUpdate: this.update,
                onFinish: this.finish,
            });
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
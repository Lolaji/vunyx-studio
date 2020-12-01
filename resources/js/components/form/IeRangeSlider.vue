<template>
    <div class="row">
        <label class="label col-md-3 pt-4"><slot name="label">Label</slot></label>
        <div class="col-md-7" style="background: #353537">
            <ie-range-slider
                skin="round"
                :min="min"
                :max="max"
                :step="step"
                :from="from"
                :hide-min-max="true"
                @change="ieRangeChange"
                @ready="ieRangeReady"></ie-range-slider>
        </div>
    </div>
</template>
<script>
    import IeRangeSlider from '../IonRangeSlider';

    export default {
        props: {
            min: {
                type: Number,
                default: () => 0.00
            },
            max: {
                type: Number,
                default: () => 100.00
            },
            step: {
                type: Number,
                default: () => 0.01
            },
            from: {
                type: [Number, String],
                default: () => 0.0
            },
            selectedLayerIndex: {
                type: Number,
                default: () => null
            }
        },
        components: {
            IeRangeSlider
        },
        data() {
            return {
                instance: null,
                layerIndex: null
            }
        },
        methods: {
            ieRangeChange(e){
                this.$emit('change', e.from);
            },
            ieRangeReady(instance){
                this.instance = instance;
            }
        },
        updated() {
            //checks if the selectedLayerIndex prop is not null
            //checks the layerIndex data is not equals to selectedLayerIndex prop
            //initialize layerIndex data with the new selectedLayerIndex prop
            //and update the slider 
            if (!_.isNull(this.selectedLayerIndex)){
                if (this.layerIndex != this.selectedLayerIndex) {
                    this.layerIndex = this.selectedLayerIndex;

                    this.instance.update({
                        from: this.from
                    })
                }
            }
        },
        mounted() {
            if (!_.isNull(this.selectedLayerIndex)){
                this.layerIndex = this.selectedLayerIndex;
            }
        }
    }
</script>
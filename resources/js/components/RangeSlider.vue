<template>
    <div>
        <range-slider
            v-bind="$attrs"
            :min="min"
            :max="max"
            :step="step"
            :value="value"
            :class="classes"
            v-on:change="$emit('change', $event.target.value)"></range-slider>
    </div>
</template>

<script>
import RangeSlider from 'vue-range-slider';
// import 'vue-range-slider/dist/vue-range-slider.css';

export default {
    props:{
        model: {
            type: Number
        },
        min: {
            type: Number,
        },
        max: {
            type: Number
        },
        step: {
            type: Number
        },
        classes: {
            type: [String, Object]
        },
        value: {
            type: Number
        }
    },
    components:{RangeSlider}
}
</script>
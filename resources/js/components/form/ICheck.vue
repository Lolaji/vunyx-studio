<template>
    <div class="icheck-light-yellow d-inline">
        <input 
            :type="type" 
            id="iCheck"
            v-model="model"
            @change="iCheckChange">
        <label for="iCheck"><slot>Label</slot></label>
    </div>
</template>
<script>
    export default {
        props: {
            type: {
                type: String,
                default: () => 'radio'
            },
            value: {
                type: Boolean
            }
        },
        data(){
            return {
                model: false
            }
        },
        methods: {
            iCheckChange(e) {
                this.$emit('change', e);
            }
        },
        updated() {
            
        },
        mounted(){
            if (value)
                this.model = this.value;
        }
    }
</script>
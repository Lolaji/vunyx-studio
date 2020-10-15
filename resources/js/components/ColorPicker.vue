<template>
    <div class="form-group mb-1" :class="classes" :id="id">
        <div class="row">
            <label for="" class="col-4 lable pt-1">
                <slot name="label">Color</slot>
            </label>
            <div class="col-8">
                <div class="row">
                    <div class="col-2 pt-2" v-if="useTransparent">
                        <span data-toggle="tooltip" data-placement="bottom" title="Transparent">
                            <div class="icheck-light-yellow d-inline">
                                <input type="checkbox" v-model="isTransparent" @change="onChangeTransparent" id="checkboxPrimary3">
                                <label for="checkboxPrimary3"></label>
                            </div>
                        </span>
                    </div>
                    <div class="col-8">
                        <div class="input-group ie my-colorpicker">
                            <input :value="value" :disabled="isTransparent" type="text" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                            </div>
                        </div>
                    </div>
                    <slot name="right-content"></slot>
                </div>
                <!-- <slot name="left-content"></slot> -->
                <!-- <div class="input-group ie my-colorpicker">
                    <input :value="model" type="text" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>
<script>
    import '../../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js';
    import '../../assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css';

    export default {
        props: {
            id : {
                type: String
            },
            model: {
                type: String
            },
            classes: {
                type: [String, Object]
            },
            useTransparent: {
                type: Boolean,
                default: () => false
            }
        },
        data(){
            return {
                value: '',
                elem: null,
                colorPicked: '',
                isTransparent: false
            }
        },
        methods: {
            onChangeTransparent(){
                if (this.isTransparent) {
                    this.$emit('change', 'transparent');
                    this.inputColor('transparent');
                }
            },
            inputColor(color=''){
                this.value = color;
                $(this.elem+ ' .my-colorpicker .fa-square').css('color', color);
            },
            checkInputTransparent (){
                if ((this.model == 'transparent') && !this.isTransparent) {
                    this.isTransparent = true;
                }
            }
        },
        updated(){
            this.elem = '#'+this.id;
            if (this.model) {
                if (!this.isTransparent){
                    this.colorPicked = this.model;
                }
                this.inputColor(this.model);
            }

            // this.checkInputTransparent();
        },
        mounted() {
            this.elem = '#'+this.id;
            if (this.model) {
                this.inputColor(this.model);
            }
            // this.checkInputTransparent();
            
            $(this.elem+ ' .my-colorpicker').colorpicker();

            $(this.elem+ ' .my-colorpicker').on('colorpickerChange', (event) => {
                this.colorPicked = event.color.toString();
                this.$emit('change', event.color.toString());
                this.inputColor(event.color.toString());
            });
        }
    }
</script>

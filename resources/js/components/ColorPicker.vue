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
                                <input type="checkbox" v-model="isTransparent" id="checkboxPrimary3">
                                <label for="checkboxPrimary3"></label>
                            </div>
                        </span>
                    </div>
                    <div class="col-8">
                        <div class="input-group ie my-colorpicker">
                            <input :value="model" :disabled="isTransparent" type="text" class="form-control">
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
                isTransparent: false
            }
        },
        methods: {
            onChangeTransparent(e){
                console.log(e.target.value)
            }
        },
        updated(){
            let id = '#'+this.id;
            if (this.model) {
                $(id+ ' .my-colorpicker .fa-square').css('color', this.model);
            }

            if (this.isTransparent) {
                this.$emit('change', 'transparent');
                this.model = 'transparent';
                $(id+ ' .my-colorpicker .fa-square').css('color', 'transparent');
            }
        },
        mounted() {
            let id = '#'+this.id;
            if (this.model) {
                $(id+ ' .my-colorpicker .fa-square').css('color', this.model);
            }
            console.log(this.model);
            $(id+ ' .my-colorpicker').colorpicker();

            $(id+ ' .my-colorpicker').on('colorpickerChange', (event) => {
                $(id+ ' .my-colorpicker .fa-square').css('color', event.color.toString());
                this.$emit('change', event.color.toString());
            });
        }
    }
</script>

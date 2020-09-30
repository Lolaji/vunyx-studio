<template>
    <div class="form-group mb-1" :class="classes" :id="id">
        <div class="row">
            <label for="" class="col-4 lable pt-1">
                <slot name="label">Color</slot>
            </label>
            <div class="col-8">
                <div class="input-group ie my-colorpicker">
                    <input :value="model" type="text" class="form-control col-5">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                    </div>
                </div>
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
            }
        },
        data(){
            return {
                value: '',
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

<template>
    <div class="col-12 mb-1" :class="classes">
        <div class="row">
            <label for="" class="col-4 lable pt-1">
                <slot name="label">Color</slot>
            </label>
            <div class="col-8">
                <div class="input-group color my-colorpicker2">
                    <input type="text" class="form-control">
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
            model: {
                type: String
            },
            classes: {
                type: [String, Object]
            }
        },
        mounted() {
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', (event) => {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                this.$emit('change', event.color.toString());
            });
        }
    }
</script>
<style lang="scss" scoped>
    .input-group {
        &.color {
            .form-control {
                &:focus {
                    & + .input-group-append {
                        .input-group-text {
                            border: 1px solid #e1c238;
                        }
                    }
                }
            }
            .input-group-append {
                .input-group-text {
                    background: #414141;
                    border: 1px solid #515155;
                }
            }
        }
    }
</style>
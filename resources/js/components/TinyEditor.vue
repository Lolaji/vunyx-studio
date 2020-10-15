<template>
    <t-editor
        :api-key="process.env.MIX_TINYMCE_API_KEY"
        :init="init"
        v-bind="$attrs"></t-editor>
</template>
<script>
import TEditor from '@tinymce/tinymce-vue';
export default {
    components:{TEditor},
    data(){
        return {
            init: {
                height: 100,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar:
                'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help'
            }
        }
    }
}
</script>
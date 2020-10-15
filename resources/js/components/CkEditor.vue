<template>
    <editor 
        v-bind="$attrs"
        :editor="buildParckage"
        :tag-name="tagName"
        :value="value"
        :config="config"
        :disabled="disabled"
        @ready="onReady"
        @focus="onFocus"
        @blur="onBlur"
        @input="onInput"
        @destroy="onDestroy"></editor>
</template>

<script>
import Editor from '@ckeditor/ckeditor5-vue';

// build packages
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Plugins
// import EssentialsPlugin from '@ckeditor/ckeditor5-vue';
// import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';


export default {
    props: {
        editor: {
            type: String,
            default: () => 'classic',
            validator: (value) => {
                return ['classic', 'inline', 'balloon', 'balloon-block', 'decoupled-document'].indexOf(value) > -1;
            }
        },
        tagName: {
            type: String,
            default: () => 'textarea'
        },
        value: {
            type: String
        },
        disabled: {
            type: Boolean,
            default: () => false
        }
    },
    components:{Editor: Editor.component},
    data(){
        return {
            model: '<p></p>',
            config: {
                // plugins: [],
                // toolbar: {
                //     items: ['heading', '|', 'bold', 'italic', 'link', 'fontColor', 
                //     'bulletedList', 'numberedList', 'blockQuote', 'indent:increase', 'indent:decrease', 'table']
                // },
                removePlugins: ['Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed',
                                'CKFinderUploadAdapter'],
            },
            buildParckage: ClassicEditor,
        }
    },
    methods: {
        onReady(editor) {
            this.$emit('ready', editor);
        },
        onFocus(editor){
            this.$emit('focus', editor);
        },
        onBlur(editor){
            this.$emit('blur', editor);
        },
        onInput(editor){
            this.$emit('input', editor);
        },
        onDestroy(editor){
            this.$emit('destroy', editor);
        },
        setBuildParckage(name='classic') {
            switch(name) {
                case 'classic':
                    this.buildParckage = ClassicEditor;
                    break;
            }
        }
    },
    created(){
        if (this.editor)
            this.setBuildParckage(this.editor);

        ClassicEditor.builtinPlugins.map( plugin => console.log(plugin.pluginName) );
    }
}
</script>


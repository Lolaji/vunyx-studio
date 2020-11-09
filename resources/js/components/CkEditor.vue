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
// import FontFamily from '@ckeditor/ckeditor5-font/src/fontfamily';
// import FontSize from '@ckeditor/ckeditor5-font/src/fontSize'


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
                // plugins: [FontFamily, FontSize],
                removePlugins: ['Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed',
                                'CKFinderUploadAdapter'],
                fontFamily: {
                    options: [
                        // 'default',
                        // 'Ubuntu, Arial, sans-serif',
                        // 'Ubuntu Mono, Courier New, Courier, monospace'
                    ],
                     supportAllValues: true
                },
                fontSize: {
                    options: ['default',2,4,6,8,10,15,20]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
                // toolbar: ['heading', '|', 'bold', 'italic', 'link', 'fontFamily', 'fontSize', 
                //     'bulletedList', 'numberedList', 'blockQuote', 'indent', 'outdent', 'table'],
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


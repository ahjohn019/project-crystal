<template>
    <ckeditor
        :editor="editor"
        :value="modelValue"
        @input="$emit('update:modelValue', $event)"
        :config="editorConfig"
    ></ckeditor>
</template>

<script>
import { ClassicEditor } from '@ckeditor/ckeditor5-editor-classic';

import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';
import { Link } from '@ckeditor/ckeditor5-link';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
import {
    Image,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
} from '@ckeditor/ckeditor5-image';
import { Base64UploadAdapter } from '@ckeditor/ckeditor5-upload';

export default {
    props: {
        modelValue: String,
    },
    setup() {
        return {
            editor: ClassicEditor,
            editorData: '<p>Content of the editor.</p>',
            editorConfig: {
                plugins: [
                    Essentials,
                    Bold,
                    Italic,
                    Link,
                    Paragraph,
                    Image,
                    ImageResize,
                    ImageStyle,
                    ImageToolbar,
                    ImageUpload,
                    Base64UploadAdapter,
                ],

                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        'link',
                        'undo',
                        'redo',
                        'imageUpload',
                    ],
                },
                image: {
                    toolbar: [
                        'imageStyle:block',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative',
                        '|',
                        'link',
                    ],
                },
            },
        };
    },
};
</script>

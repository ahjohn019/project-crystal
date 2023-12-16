<template>
    <ckeditor
        :editor="editor"
        v-model="editorData"
        :config="editorConfig"
        @input="handleDescriptionsData"
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
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Indent, IndentBlock } from '@ckeditor/ckeditor5-indent';
import { List } from '@ckeditor/ckeditor5-list';
import { Table, TableToolbar } from '@ckeditor/ckeditor5-table';

import { ref } from 'vue';

export default {
    props: {
        descriptions: String,
    },
    setup(props, { emit }) {
        const editorData = ref('');

        // editorData.value = props.descriptions;

        const handleDescriptionsData = () => {
            emit('updateDescriptionsData', editorData.value);
        };

        return {
            editor: ClassicEditor,
            editorData,
            handleDescriptionsData,
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
                    Heading,
                    Indent,
                    IndentBlock,
                    List,
                    Table,
                    TableToolbar,
                ],

                toolbar: {
                    items: [
                        'heading',
                        'bold',
                        'italic',
                        'link',
                        'undo',
                        'redo',
                        'imageUpload',
                        'outdent',
                        'indent',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                    ],
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
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
                heading: {
                    options: [
                        {
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph',
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1',
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2',
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3',
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4',
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5',
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6',
                        },
                    ],
                },
            },
        };
    },
};
</script>

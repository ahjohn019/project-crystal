<template>
    <BasePage>
        <template #content>
            <div class="dashboard-container-page m-4 px-4">
                <div class="row pb-4">
                    <div class="col text-2xl">Post Form</div>
                </div>
                <div class="row bg-white p-5 font-bold gap-y-4">
                    <div class="col-12 post-information-title pb-2">
                        Post Information
                    </div>
                    <div class="col-12">
                        <div class="post-information-title">Name</div>
                        <div class="col-12">
                            <q-input
                                outlined
                                dense
                                label="Name"
                                v-model="postFormPayload.name"
                            >
                            </q-input>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="post-information-title">Descriptions</div>
                        <div class="col-12">
                            <CkeditorPlugin
                                v-model="postFormPayload.descriptions"
                            />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="post-information-title">Images</div>
                        <DropFile @updateFiles="updateParentFiles" />
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="post-information-title">Likes</div>
                        <q-radio
                            v-model="postFormPayload.likes"
                            val="yes"
                            label="Yes"
                        />
                        <q-radio
                            v-model="postFormPayload.likes"
                            val="no"
                            label="No"
                        />
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="post-information-title">Comments</div>
                        <q-radio
                            v-model="postFormPayload.comments"
                            val="yes"
                            label="Yes"
                        />
                        <q-radio
                            v-model="postFormPayload.comments"
                            val="no"
                            label="No"
                        />
                    </div>
                    <div class="col-12 text-right">
                        <q-btn
                            label="Submit"
                            class="text-white bg-primary update-form-button"
                            @click="updatePostFormData"
                        />
                    </div>
                </div>
            </div>
        </template>
    </BasePage>
</template>

<script>
import BasePage from '@admin/modules/base/views/BasePage.vue';
import CkeditorPlugin from '@admin/components/ckeditor/ckEditorPlugin.vue';
import DropFile from '@admin/components/dragAndDrop/DropFile.vue';
import { ref } from 'vue';

export default {
    components: {
        BasePage,
        CkeditorPlugin,
        DropFile,
    },

    setup() {
        const postFormPayload = ref({
            name: '',
            descriptions: '',
            images: [],
            likes: 'yes',
            comments: 'yes',
        });

        const updateParentFiles = (files) => {
            postFormPayload.value.images = files;
        };

        const updatePostFormData = () => {
            console.log(postFormPayload.value);
        };

        return {
            postFormPayload,
            updatePostFormData,
            updateParentFiles,
        };
    },
};
</script>

<style>
.post-information-title {
    font-size: 16px;
    padding-bottom: 0.5rem;
}
.update-form-button .block {
    font-weight: bold;
}
</style>

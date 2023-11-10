<template>
    <BasePage>
        <template #content>
            <div class="dashboard-container-page m-4 px-4">
                <div class="row pb-4">
                    <div class="col text-2xl">Post Form</div>
                </div>
                <div class="row bg-white p-5 font-bold gap-4">
                    <div class="col-12 post-information-title pb-2">
                        Post Information
                    </div>
                    <div class="col-12">
                        <div class="col-12 post-information-title">Name</div>
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
                        <div class="col-12 post-information-title">
                            Descriptions
                        </div>
                        <div class="col-12">
                            <CkeditorPlugin
                                v-model="postFormPayload.descriptions"
                            />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-12 post-information-title">Images</div>
                        <DropFile />
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
        });

        const updatePostFormData = () => {
            console.log(postFormPayload.value);
        };

        return {
            postFormPayload,
            updatePostFormData,
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

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
                        <div class="post-information-title">Title</div>
                        <div class="col-12">
                            <q-input
                                outlined
                                dense
                                label="Title"
                                v-model="postFormPayload.title"
                                ref="nameRef"
                            >
                            </q-input>
                        </div>
                        <div class="col-12 text-red-700">
                            {{ errors.title }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="post-information-title">Descriptions</div>
                        <div class="col-12">
                            <CkeditorPlugin
                                v-model="postFormPayload.descriptions"
                            />
                        </div>
                        <div class="col-12 text-red-700">
                            {{ errors.descriptions }}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="post-information-title">Category</div>
                        <div class="col-12">
                            <q-select
                                outlined
                                dense
                                v-model="postFormPayload.category_id"
                                :options="options"
                                label="Category"
                            />
                        </div>
                        <div class="col-12 text-red-700">
                            {{ errors.category_id }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="post-information-title">Images</div>
                        <DropFile @updateFiles="updateParentFiles" />
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="post-information-title">Status</div>
                        <q-radio
                            v-model="postFormPayload.status"
                            val="1"
                            label="Yes"
                        />
                        <q-radio
                            v-model="postFormPayload.status"
                            val="0"
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
import { usePostTablePageAdminStore } from '@shared_admin/post/postTablePage.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { useRefListStore } from '@shared_admin/ref/refList.js';
import { ref } from 'vue';

export default {
    components: {
        BasePage,
        CkeditorPlugin,
        DropFile,
    },

    setup() {
        const postFormPayload = ref({
            title: '',
            descriptions: '',
            images: [],
            status: '1',
            category_id: { label: 'News', value: 1 },
        });

        const model = ref(null);
        const options = ref([]);
        const errors = ref({
            title: null,
            descriptions: null,
            images: null,
            status: null,
            category_id: null,
        });

        const postTablePageAdminStore = usePostTablePageAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();

        const refList = useRefListStore();

        const categoryList = async () => {
            const response = await refList.fetchCategoryList(getAuthToken);

            options.value = response.map((obj) => {
                return { label: obj.name, value: obj.id };
            });
        };

        const updateParentFiles = (files) => {
            postFormPayload.value.images = files;
        };

        const updatePostFormData = async () => {
            postFormPayload.value.category_id =
                postFormPayload.value.category_id.value;

            const response = await postTablePageAdminStore.createPost(
                getAuthToken,
                postFormPayload.value,
                errors
            );

            handlePostFormErrors(response);
        };

        const handlePostFormErrors = (response) => {
            if (response.status === 422) {
                const errorResponse = response.data.errors;

                errors.value = {
                    ...errors.value,
                    title: errorResponse.title?.[0] ?? null,
                    descriptions: errorResponse.descriptions?.[0] ?? null,
                    category_id: errorResponse.category_id?.[0] ?? null,
                };
            }
        };

        categoryList();

        return {
            postFormPayload,
            updatePostFormData,
            updateParentFiles,
            model,
            options,
            errors,
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

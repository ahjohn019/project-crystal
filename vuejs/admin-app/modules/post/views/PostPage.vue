<template>
    <BasePage>
        <template #content>
            <div class="dashboard-container-page m-4 px-4">
                <div class="row">
                    <div class="col text-2xl">Post List</div>
                    <div class="col text-right">
                        <q-btn
                            icon-right="add"
                            label="Add Posts"
                            class="add-posts text-white"
                            color="primary"
                            :to="{
                                name: 'posts.form',
                                query: { type: 'create' },
                            }"
                        />

                        <!-- <q-dialog v-model="openPostsModal">
                            <q-card style="width: 650px">
                                <q-card-section
                                    class="row justify-between q-pb-none"
                                >
                                    <div class="text-h6">Add Posts</div>
                                    <q-btn
                                        icon="close"
                                        flat
                                        round
                                        dense
                                        v-close-popup
                                        @click="handlePostsForm"
                                    />
                                </q-card-section>

                                <q-card-section class="row">
                                    <div class="col-12">
                                        <label for="title">title</label>
                                        <q-input outlined dense />
                                    </div>
                                    <div class="col-12">
                                        <label for="title">description</label>
                                        <div>
                                            <CkEditorPlugin />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </q-dialog> -->
                    </div>
                </div>
                <FilterBar />
                <TablePage />
            </div>
        </template>
    </BasePage>
</template>

<script>
import BasePage from '@admin/modules/base/views/BasePage.vue';
import FilterBar from '@admin/components/post/FilterBar.vue';
import TablePage from '@admin/components/post/TablePage.vue';

// import CkEditorPlugin from '@admin/components/ckeditor/ckeditorPlugin.vue';

// import { ref } from 'vue';

export default {
    components: {
        BasePage,
        FilterBar,
        TablePage,
        // CkEditorPlugin,
    },
    // setup() {
    //     const openPostsModal = ref(true);

    //     const handlePosts = () => {
    //         openPostsModal.value = true;
    //     };

    //     const handlePostsForm = () => {
    //         this.router.push('/form');
    //     };

    //     return {
    //         openPostsModal,
    //         handlePosts,
    //         handlePostsForm,
    //     };
    // },
};
</script>

<style>
.add-posts {
    font-weight: bold;
    border-radius: 6px;
}
</style>

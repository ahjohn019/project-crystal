<template>
    <BasePage>
        <template #content>
            <div class="dashboard-container-page m-4 px-4">
                <div class="row py-4">
                    <div class="col text-2xl">Post Form</div>
                </div>
                <div class="row bg-white p-5">
                    <div class="col-12 post-information-title pb-2">
                        Post Information
                    </div>
                    <div class="col-12 py-2">
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
                    <div class="col-12 py-2">
                        <div class="col-12 post-information-title">
                            Descriptions
                        </div>
                        <div class="col-12">
                            <q-input
                                outlined
                                type="textarea"
                                label="Descriptions"
                                v-model="postFormPayload.descriptions"
                            >
                            </q-input>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </BasePage>
</template>

<script>
import BasePage from '@admin/modules/base/views/BasePage.vue';
import { ref } from 'vue';

export default {
    components: {
        BasePage,
    },

    setup() {
        const postFormPayload = ref({
            name: '',
            descriptions: '',
        });

        return {
            postFormPayload,
        };
    },
};
</script>

<style>
.post-information-title {
    font-size: 16px;
    padding-bottom: 0.5rem;
}
</style>

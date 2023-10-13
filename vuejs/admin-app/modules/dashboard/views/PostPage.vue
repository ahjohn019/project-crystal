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
                        />
                    </div>
                </div>
                <FilterBar />
            </div>
        </template>
    </BasePage>
</template>

<script>
import BasePage from '@admin/modules/base/views/BasePage.vue';
import FilterBar from '@admin/components/post/FilterBar.vue';

export default {
    components: {
        BasePage,
        FilterBar,
    },
    setup() {},
};
</script>

<style>
.add-posts {
    background: #5541d7;
    font-weight: bold;
    border-radius: 6px;
}
</style>

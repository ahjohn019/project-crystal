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
                        />
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

export default {
    components: {
        BasePage,
        FilterBar,
        TablePage,
    },
    setup() {},
};
</script>

<style>
.add-posts {
    font-weight: bold;
    border-radius: 6px;
}
</style>

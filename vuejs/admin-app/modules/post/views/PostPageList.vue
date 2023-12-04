<template>
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
            </div>
        </div>
        <TablePage />
    </div>
</template>

<script>
import TablePage from '@admin/components/post/TablePage.vue';

export default {
    components: {
        TablePage,
    },
};
</script>

<style>
.add-posts {
    font-weight: bold;
    border-radius: 6px;
}
</style>

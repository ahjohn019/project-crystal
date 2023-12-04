<template>
    <BasePage>
        <template #content>
            <router-view></router-view>
        </template>
    </BasePage>
</template>

<script>
import BasePage from '@admin/modules/base/views/BasePage.vue';

export default {
    components: {
        BasePage,
    },
};
</script>

<style>
.add-posts {
    font-weight: bold;
    border-radius: 6px;
}
</style>

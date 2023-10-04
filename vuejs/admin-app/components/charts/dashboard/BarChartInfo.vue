<template>
    <div
        class="dashboard-bar-chart col-12 col-md-2 row justify-center bg-white p-4 md:rounded-bl-lg"
    >
        <div class="col-6 col-md-12">
            <div class="text-sm">This Month's Total</div>
            <div class="font-bold" style="font-size: 1.5rem">
                {{ monthlyPostInit.monthly_count }}
            </div>
        </div>
        <div class="col-6 col-md-12">
            <div class="text-sm">Top Category</div>
            <div
                v-for="(data, key) in topCategoryInit.top_category"
                :key="key"
                class="font-bold"
                style="font-size: 1.5rem"
            >
                {{ data.category.name }}
            </div>
        </div>
        <div class="col-6 col-md-12">
            <div class="text-sm">Highest Liked By Month</div>
            <div class="font-bold" style="font-size: 1.5rem">
                {{ highestLikesInit.likes ?? 0 }}
            </div>
        </div>
        <div class="col-6 col-md-12">
            <div class="text-sm">Highest Comment By Month</div>
            <div class="font-bold" style="font-size: 1.5rem">
                {{ highestCommentsInit.comments ?? 0 }}
            </div>
        </div>
    </div>
</template>

<script>
import { useBarChartsAdminStore } from '@shared_admin/dashboard/barChartDetails.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { onMounted, ref } from 'vue';

export default {
    setup() {
        const barChartsAdminStore = useBarChartsAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();
        const monthlyPostInit = ref([]);
        const topCategoryInit = ref([]);
        const highestLikesInit = ref([]);
        const highestCommentsInit = ref([]);
        const retrieveBarChartDataInit = ref([]);

        const fetchMonthlyPost = async () => {
            try {
                monthlyPostInit.value =
                    await barChartsAdminStore.fetchMonthlyPost(getAuthToken);
            } catch (error) {
                console.error(error);
            }
        };

        const fetchTopCategory = async () => {
            try {
                topCategoryInit.value =
                    await barChartsAdminStore.fetchTopCatergory(getAuthToken);
            } catch (error) {}
        };

        const fetchHighestLikes = async () => {
            try {
                highestLikesInit.value =
                    await barChartsAdminStore.fetchHighestLikes(getAuthToken);
            } catch (error) {}
        };

        const fetchHighestComments = async () => {
            try {
                highestCommentsInit.value =
                    await barChartsAdminStore.fetchHighestComments(
                        getAuthToken
                    );
            } catch (error) {}
        };

        const retrieveBarChartData = async () => {
            try {
                retrieveBarChartDataInit.value =
                    await barChartsAdminStore.retrieveBarChartData(
                        getAuthToken
                    );
            } catch (error) {}
        };

        onMounted(async () => {
            await Promise.all([
                fetchMonthlyPost(),
                fetchTopCategory(),
                fetchHighestLikes(),
                fetchHighestComments(),
                retrieveBarChartData(),
            ]);
        });

        return {
            monthlyPostInit,
            topCategoryInit,
            highestLikesInit,
            highestCommentsInit,
        };
    },
};
</script>

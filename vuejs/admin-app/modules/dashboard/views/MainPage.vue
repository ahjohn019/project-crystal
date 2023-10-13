<template>
    <BasePage>
        <template #content>
            <div class="m-4 justify-center dashboard-container-page">
                <card-details class="to-animate card-details" />
                <bar-chart class="to-animate bar-chart" />
                <bar-performance class="to-animate bar-performance" />
            </div>
        </template>
    </BasePage>
</template>

<script>
import CardDetails from '@admin/components/dashboard/CardDetails.vue';
import BarChart from '@admin/components/charts/dashboard/BarChart.vue';
import BarPerformance from '@admin/components/dashboard/BarPerformance.vue';
import { useBaseScrollAnimationStore } from '@shared_admin/base/scrollAnimation.js';
import BasePage from '@admin/modules/base/views/BasePage.vue';

export default {
    components: {
        CardDetails,
        BarChart,
        BarPerformance,
        BasePage,
    },

    setup() {
        const baseScrollAnimationStore = useBaseScrollAnimationStore();
        const animateClassList = [
            { name: 'card-details', animation: 'animate__backInDown' },
            { name: 'bar-chart', animation: 'animate__fadeInLeft' },
            { name: 'bar-performance', animation: 'animate__fadeInRight' },
        ];

        baseScrollAnimationStore.scrollAnimation(animateClassList);
    },
};
</script>

<style>
@media (min-width: 769px) {
    .dashboard-container-page {
        padding-left: 250px;
    }
}
</style>

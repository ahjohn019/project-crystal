<template>
    <div class="pb-2">
        <div
            class="col col-12 bg-white rounded-tl-lg rounded-tr-lg p-4 font-bold border-b"
        >
            Post's Data
        </div>
        <div class="row">
            <BarChartInfo />
            <div
                style="height: 40vh"
                class="dashboard-bar-chat-graphs col bg-white p-4 rounded-bl-lg md:rounded-bl-none rounded-br-lg"
            >
                <Bar
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"
                    ref="chartRef"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { useBarChartsAdminStore } from '@shared_admin/dashboard/barChartDetails.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { Bar } from 'vue-chartjs';
import { onMounted, ref, watchEffect } from 'vue';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js';
import BarChartInfo from './BarChartInfo.vue';
import axios from 'axios';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

export default {
    name: 'BarChart',
    components: { Bar, BarChartInfo },
    setup() {
        const barChartsAdminStore = useBarChartsAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();
        const retrieveBarChartDataInit = ref([]);

        const chartData = ref({
            labels: ref([]),
            datasets: [
                {
                    label: 'Post',
                    data: Array.from(
                        { length: 12 },
                        () => Math.floor(Math.random() * 100) + 1
                    ),
                    backgroundColor: '#55AAF1',
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                    barThickness: 20,
                },
            ],
        });

        const chartOptions = ref({
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'start',
                    labels: {
                        borderRadius: 5,
                        useBorderRadius: true,
                        boxHeight: 10,
                    },
                },
            },
        });

        const retrieveBarChartData = async () => {
            try {
                const response = await barChartsAdminStore.retrieveBarChartData(
                    getAuthToken
                );

                const data = await response.json();

                chartData.value.labels = ['aaa'];

                console.log(data);
                // retrieveBarChartDataInit.value =
                //     await barChartsAdminStore.retrieveBarChartData(
                //         getAuthToken
                //     );
            } catch (error) {
                console.error(error);
            }
        };

        onMounted(() => {
            retrieveBarChartData();
        });

        chartData.value.labels = ['aaa'];

        return {
            chartData,
            chartOptions,
        };
    },
};
</script>

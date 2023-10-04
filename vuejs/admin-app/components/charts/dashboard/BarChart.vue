<template>
    <div class="pb-2 animate__animated animate__fadeInLeft">
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
                    v-if="chartLoaded"
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
    data() {
        return {
            chartLoaded: false,
            chartData: '',
            chartOptions: '',
        };
    },
    async mounted() {
        const barChartsAdminStore = useBarChartsAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();

        const response = await barChartsAdminStore.retrieveBarChartData(
            getAuthToken
        );

        this.chartLoaded = true;

        this.chartData = {
            labels: Object.keys(response.data),
            datasets: [
                {
                    label: 'Post',
                    data: Object.values(response.data),
                    backgroundColor: '#55AAF1',
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                    barThickness: 20,
                },
            ],
        };

        this.chartOptions = {
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
        };
    },
};
</script>

<template>
    <div class="pb-2">
        <div
            class="col col-12 bg-white rounded-tl-lg rounded-tr-lg p-4 font-bold border-b"
        >
            Blog Data
        </div>
        <div class="row">
            <div
                class="dashboard-bar-chart col-12 col-md-2 row justify-center bg-white p-4 md:rounded-bl-lg"
            >
                <div class="col-6 col-md-12">
                    <div class="text-sm">Total Blogs</div>
                    <div class="font-bold" style="font-size: 1.5rem">200</div>
                </div>
                <div class="col-6 col-md-12">
                    <div class="text-sm">Most View</div>
                    <div class="font-bold" style="font-size: 1.5rem">
                        Gaming
                    </div>
                </div>
                <div class="col-6 col-md-12">
                    <div class="text-sm">Highest Liked Count</div>
                    <div class="font-bold" style="font-size: 1.5rem">300</div>
                </div>
                <div class="col-6 col-md-12">
                    <div class="text-sm">Total Comment</div>
                    <div class="font-bold" style="font-size: 1.5rem">24</div>
                </div>
            </div>
            <div
                style="height: 40vh"
                class="dashboard-bar-chat-graphs col bg-white p-4 rounded-bl-lg md:rounded-bl-none rounded-br-lg"
            >
                <Bar
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { ref } from 'vue';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js';

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
    components: { Bar },
    setup() {
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
        const chartData = {
            labels: ['January', 'February', 'March', 'April'],
            datasets: [
                {
                    label: 'My Dashboards',
                    data: Array.from(
                        { length: 4 },
                        () => Math.floor(Math.random() * 100) + 1
                    ),
                    backgroundColor: '#55AAF1',
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                    barThickness: 20,
                },
                {
                    label: 'My Dashboards Two',
                    data: Array.from(
                        { length: 4 },
                        () => Math.floor(Math.random() * 100) + 1
                    ),
                    backgroundColor: '#42BDA1',
                    borderWidth: 2,
                    borderRadius: Number.MAX_VALUE,
                    borderSkipped: false,
                    barThickness: 20,
                },
            ],
        };

        return {
            chartData,
            chartOptions,
        };
    },
};
</script>

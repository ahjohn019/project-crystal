import { defineStore } from 'pinia';

import axios from 'axios';

const prefix = '/api/dashboard/';

export const useBarChartsPerformanceAdminStore = defineStore(
    'bar_charts_performance',
    {
        state: () => ({
            bar_charts_performance: null,
        }),

        actions: {
            async fetchAllPost(payload) {
                const config = {
                    headers: { Authorization: `Bearer ${payload}` },
                };

                try {
                    const response = await axios.get(prefix + 'all', config);

                    return response.data.data;
                } catch (error) {
                    console.error('Error:', error);
                    throw error;
                }
            },
        },
    }
);

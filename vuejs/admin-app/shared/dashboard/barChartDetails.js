import { defineStore } from 'pinia';
import axios from 'axios';

const prefix = '/api/dashboard/';

export const useBarChartsAdminStore = defineStore('bar_charts_admin', {
    state: () => ({
        bar_charts_admin: null,
    }),

    actions: {
        async fetchMonthlyPost(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'monthly-post',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async fetchTopCatergory(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'top-category',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async fetchHighestLikes(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'highest-likes-month',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async fetchHighestComments(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'highest-comment-month',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async retrieveBarChartData(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'bar-chart-data',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },
    },
});

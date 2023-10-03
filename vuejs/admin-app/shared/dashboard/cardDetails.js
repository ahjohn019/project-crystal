import { defineStore } from 'pinia';
import axios from 'axios';

const prefix = '/api/dashboard/';

export const useCardDetailsAdminStore = defineStore('card_details_admin', {
    state: () => ({
        card_details_admin: null,
    }),

    actions: {
        async fetchCurrentPosts(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(prefix + 'current', config);

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },
        async fetchUserList(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(prefix + 'user-list', config);

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async fetchCurrentCommentList(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(
                    prefix + 'current-comment',
                    config
                );

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

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
    },
});

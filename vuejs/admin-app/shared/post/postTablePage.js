import { defineStore } from 'pinia';
import axios from 'axios';

const prefix = '/api/post/';

export const usePostTablePageAdminStore = defineStore('post_table_admin', {
    state: () => ({
        post_table_admin: null,
    }),

    actions: {
        async fetchPostList(payload) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const response = await axios.get(prefix + 'list', config);
                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },
    },
});

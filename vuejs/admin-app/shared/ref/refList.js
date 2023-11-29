import { defineStore } from 'pinia';
import axios from 'axios';

const prefix = '/api/ref/';

export const useRefListStore = defineStore('ref_list', {
    state: () => ({
        ref_list: null,
    }),

    actions: {
        async fetchCategoryList(authToken) {
            const config = {
                headers: { Authorization: `Bearer ${authToken}` },
            };

            try {
                const response = await axios.get(prefix + 'category', config);

                return response.data.data;
            } catch (error) {}
        },
    },
});

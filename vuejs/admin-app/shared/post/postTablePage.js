import { defineStore } from 'pinia';
import axios from 'axios';

const prefix = '/api/post/';

export const usePostTablePageAdminStore = defineStore('post_table_admin', {
    state: () => ({
        post_table_admin: null,
    }),

    actions: {
        async fetchPostList(payload, page = null, tableHeader = null) {
            const config = {
                headers: { Authorization: `Bearer ${payload}` },
            };

            try {
                const pagination = '?page=' + page;

                const response = await axios.get(prefix + 'list' + pagination, {
                    params: tableHeader,
                    ...config,
                });

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        fetchPostColumns() {
            return [
                {
                    name: 'title',
                    align: 'left',
                    label: 'Title',
                    field: 'title',
                    sortable: true,
                },
                {
                    name: 'popularity',
                    align: 'left',
                    label: 'Popularity',
                    field: 'popularity',
                    sortable: true,
                },
                {
                    name: 'created_at',
                    align: 'left',
                    label: 'Created At',
                    field: 'created_at',
                    sortable: true,
                },
                {
                    name: 'status',
                    align: 'left',
                    label: 'Status',
                    field: 'status',
                    sortable: false,
                },
            ];
        },

        handleTableHeaderFunction(e) {
            let eventTarget = e.target;
            let classListTarget = eventTarget.classList;
            const checkSortable = classListTarget.contains('sortable');

            if (!checkSortable) {
                eventTarget = eventTarget.parentNode;
                classListTarget = eventTarget.classList;
            }

            let fetchAttributeSortable = eventTarget.querySelector('label');

            if (fetchAttributeSortable) {
                fetchAttributeSortable = fetchAttributeSortable.innerHTML
                    .replace(/\s+/g, '_')
                    .toLowerCase();
            }

            const handleSortable = classListTarget.contains('sort-desc')
                ? 'desc'
                : 'asc';

            return {
                attribute: fetchAttributeSortable,
                sortable: handleSortable,
            };
        },
    },
});

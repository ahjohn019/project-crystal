import { defineStore } from 'pinia';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';

const prefix = '/api/post/';

export const usePostTablePageAdminStore = defineStore('post_table_admin', {
    state: () => ({
        post_table_admin: null,
        router: useRouter(),
    }),

    actions: {
        async fetchPostList(authToken, page = null, payload = null) {
            const config = {
                headers: { Authorization: `Bearer ${authToken}` },
            };

            try {
                const pagination = '?page=' + page;

                const response = await axios.get(prefix + 'list' + pagination, {
                    params: payload,
                    ...config,
                });

                return response.data.data;
            } catch (error) {
                console.error('Error:', error);
                throw error;
            }
        },

        async createPost(authToken, payload = null) {
            const config = {
                headers: { Authorization: `Bearer ${authToken}` },
            };

            try {
                const response = await axios.post(
                    prefix + 'store',
                    payload,
                    config
                );

                this.router.push('/');

                Swal.fire({
                    text: 'Post Created Successfully',
                    icon: 'success',
                }).then((result) => {
                    if (result.isConfirmed) {
                        return response.data.data;
                    }
                });
            } catch (error) {
                return error.response;
            }
        },

        deletePost(authToken, payload = null) {
            const config = {
                headers: { Authorization: `Bearer ${authToken}` },
            };

            try {
                Swal.fire({
                    title: 'Do you want to delete this post?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(prefix + 'delete/' + payload, config);

                        Swal.fire('Deleted', '', 'success').then((result) => {
                            if (result.isConfirmed) {
                                this.router.go('/posts');
                            }
                        });
                    }
                });
            } catch (error) {
                return error.response;
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

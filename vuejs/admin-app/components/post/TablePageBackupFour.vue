\
<template>
    <FilterBar @postKeywords="handlePostKeywords" />
    <div class="q-pa-md">
        <input type="hidden" :value="attributeData" />
        <input type="hidden" :value="sortableData" />
        <q-table
            flat
            bordered
            ref="tableRef"
            :rows="rows"
            :columns="columns"
            row-key="id"
            v-model:pagination="pagination"
            v-model:selected="selected"
            :loading="loading"
            binary-state-sort
            @request="onRequest"
            :selected-rows-label="getSelectedString"
            selection="multiple"
            class="posts-table"
        >
        </q-table>
        <div class="q-mt-md">Selected: {{ JSON.stringify(selected) }}</div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { usePostTablePageAdminStore } from '@shared_admin/post/postTablePage.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import FilterBar from '@admin/components/post/FilterBar.vue';
import dayjs from 'dayjs';

export default {
    components: {
        FilterBar,
    },

    setup() {
        const tableRef = ref();
        const rows = ref([]);
        const columns = ref([]);

        const filter = ref('');
        const loading = ref(false);
        const pagination = ref({
            sortBy: 'title',
            descending: false,
            page: 1,
            rowsPerPage: 15,
            rowsNumber: null,
        });
        const selected = ref([]);

        const attributeData = ref('');
        const sortableData = ref('');

        const payload = ref({});

        const postTablePageAdminStore = usePostTablePageAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();

        const fetchPagination = (pagination) => {
            const { page, rowsPerPage, sortBy, descending } = pagination;

            payload.value = {
                ...payload.value,
                attribute: sortBy,
                sortable: descending ? 'desc' : 'asc',
                page,
                paginate: rowsPerPage,
            };

            if (payload.value.paginate <= 0) {
                payload.value.paginate = pagination.rowsNumber;
            }

            return payload.value;
        };

        const handlePostKeywords = (keywords) => {
            payload.value = {
                ...payload.value,
                keyword: keywords,
                searchable: ['title', 'content'],
                page: 1,
            };

            fetchServer(null, payload.value);
        };

        const fetchServer = async (paginate, payload) => {
            const { page, rowsPerPage, sortBy, descending } = paginate ?? {
                page: null,
                rowsPerPage: null,
                sortBy: null,
                descending: null,
            };

            loading.value = true;

            // fetch data from posts
            const response = await postTablePageAdminStore.fetchPostList(
                getAuthToken,
                page,
                payload
            );

            // update the row data
            const updatedData = response.data.map((item) => {
                return {
                    ...item,
                    created_at: dayjs(item.created_at).format(
                        'YYYY-MM-DD HH:mm:ss'
                    ),
                };
            });

            // update the local data
            rows.value = updatedData;

            pagination.value = {
                ...pagination.value,
                rowsNumber: response.meta.total,
                page,
                rowsPerPage,
                sortBy,
                descending,
            };

            payload.rowsPerPage = response.meta.per_page;
            payload.attribute = attributeData;
            payload.sortable = sortableData;

            // turn off the loading
            loading.value = false;

            return response;
        };

        const onRequest = async (props) => {
            const payload = fetchPagination(props.pagination);

            // get ajax columns
            const fetchColumnnList = postTablePageAdminStore.fetchPostColumns();
            columns.value = fetchColumnnList;

            // fetch data from posts
            const response = fetchServer(props.pagination, payload);

            return response;
        };

        onMounted(() => {
            tableRef.value.requestServerInteraction();
        });

        return {
            tableRef,
            filter,
            loading,
            pagination,
            columns,
            rows,
            onRequest,
            selected,
            fetchPagination,
            attributeData,
            sortableData,
            handlePostKeywords,
            getSelectedString() {
                console.log(selected.value);
                return selected.value.length === 0
                    ? ''
                    : `${selected.value.length} record${
                          selected.value.length > 1 ? 's' : ''
                      } selected of ${rows.value.length}`;
            },
        };
    },
};
</script>

\
<template>
    <FilterBar @postKeywords="handlePostKeywords" />
    <div class="pt-5">
        <q-table
            flat
            ref="tableRef"
            bordered
            :grid="$q.screen.lt.sm"
            :rows="rows"
            :columns="columns"
            v-model:pagination="pagination"
            v-model:selected="selected"
            :loading="loading"
            binary-state-sort
            @request="onRequest"
            :selected-rows-label="getSelectedString"
            selection="multiple"
            class="posts-table"
        >
            <template v-slot:header-cell="props">
                <q-th :props="props">
                    <label :for="props.col.label" class="font-bold text-sm">
                        {{ props.col.label }}
                    </label>
                </q-th>
            </template>
            <template v-slot:body-cell="props">
                <q-td :props="props" class="font-bold">
                    <div>{{ props.value }}</div>
                </q-td>
            </template>
            <template v-slot:body-cell-title="props">
                <q-td :props="props">
                    <div class="font-bold table-likes-columns">{{ props.value }}</div>
                    <div class="q-table-label">
                        Likes : {{ props.row.likes }}
                    </div>
                </q-td>
            </template>
            <template v-slot:body-cell-popularity="props">
                <q-td :props="props">
                    <div class="flex gap-2">
                        <div><span class="q-table-label">Score </span></div>

                        <div>
                            <q-badge
                                color="positive"
                                style="font-weight: bold"
                                class="capitalize p-2 rounded"
                                :label="
                                    props.row.popularity_percentage + '%'
                                "
                            />
                        </div>

                        <div>
                            <q-badge
                                color="positive"
                                style="font-weight: bold"
                                class="capitalize p-2 rounded"
                                :label="props.row.popularity_grade"
                            />
                        </div>
                    </div>
                    <div>
                        <q-linear-progress
                            rounded
                            size="15px"
                            :value="parseFloat(props.value)"
                            class="q-mt-sm rounded q-table-custom-progress-bar"
                        />
                    </div>
                </q-td>
            </template>
            <template v-slot:body-cell-status="props">
                <q-td :props="props">
                    <div class="flex">
                        <div>
                            <q-btn-dropdown
                                color="transparent"
                                class="text-black font-bold"
                                dropdown-icon="expand_more"
                            >
                                <template v-slot:label>
                                    <div
                                        class="row items-center no-wrap font-bold"
                                    >
                                        Edit
                                    </div>
                                </template>
                                <q-list class="q-table-edit-dropdown-list">
                                    <q-item clickable :to="'/posts/view/'+ props.row.id ">
                                        <q-item-section>
                                            <q-icon name="visibility" />
                                        </q-item-section>
                                        <q-item-section>
                                            <q-item-label
                                                >View </q-item-label
                                            >
                                        </q-item-section>
                                    </q-item>

                                    <q-item clickable>
                                        <q-item-section>
                                            <q-icon name="edit" />
                                        </q-item-section>
                                        <q-item-section>
                                            <q-item-label
                                                >Edit</q-item-label
                                            >
                                        </q-item-section>
                                    </q-item>

                                    <q-item
                                        clickable
                                        @click="
                                            handlePostDelete(props.row.id)
                                        "
                                    >
                                        <q-item-section>
                                            <q-icon name="delete" />
                                        </q-item-section>
                                        <q-item-section>
                                            <q-item-label
                                                >Delete</q-item-label
                                            >
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-btn-dropdown>
                        </div>
                    </div>
                </q-td>
            </template>
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
                attribute: 'title',
                sortable: 'asc',
                paginate: 15,
            };

            fetchServer(null, payload.value);
        };

        const fetchServer = async (paginate, payload) => {
            const { page, rowsPerPage, sortBy, descending } = paginate ?? {
                page: 1,
                rowsPerPage: 15,
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

<style scoped>
    .table-likes-columns{
        max-width: 250px;
        text-wrap: wrap;
    }
</style>

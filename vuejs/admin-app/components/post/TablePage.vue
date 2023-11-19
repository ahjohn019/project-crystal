<template>
    <div class="row mt-5">
        <input type="hidden" :value="attributeData" />
        <input type="hidden" :value="sortableData" />
        <div class="col">
            <q-table
                flat
                bordered
                :rows="rows"
                :columns="columns"
                :selected-rows-label="getSelectedString"
                selection="multiple"
                v-model:selected="selected"
                v-model:pagination="pagination"
                binary-state-sort
                class="posts-table"
                @click="handleTableHeaderClick"
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
                        <div class="font-bold">{{ props.value }}</div>
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
                                        <q-item clickable>
                                            <q-item-section>
                                                <q-icon name="visibility" />
                                            </q-item-section>
                                            <q-item-section>
                                                <q-item-label
                                                    >View</q-item-label
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

                                        <q-item clickable>
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
            <div class="q-pa-lg flex flex-center">
                <q-pagination
                    v-model="current"
                    :max="totalPaginationNumber"
                    :max-pages="5"
                    :boundary-numbers="false"
                    direction-links
                    boundary-links
                    icon-first="skip_previous"
                    icon-last="skip_next"
                    icon-prev="fast_rewind"
                    icon-next="fast_forward"
                    :to-fn="(page) => ({ query: { page } })"
                    @click="fetchPagination"
                >
                </q-pagination>
            </div>
            <div class="q-mt-md">Selected: {{ JSON.stringify(selected) }}</div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { usePostTablePageAdminStore } from '@shared_admin/post/postTablePage.js';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import dayjs from 'dayjs';
import { useRoute } from 'vue-router';

export default {
    setup() {
        const current = ref(1);
        const selected = ref([]);
        const status = ref({});

        const columns = ref([]);
        const rows = ref([]);

        const postTablePageAdminStore = usePostTablePageAdminStore();
        const adminAuthStore = useAdminAuthStore();
        const getAuthToken = adminAuthStore.fetchSessionToken();
        const route = useRoute();

        const attributeData = ref('');
        const sortableData = ref('');

        const totalPaginationNumber = ref(0);

        const pagination = ref({
            rowsPerPage: 0,
        });

        const fetchPagination = async (e) => {
            const paginationPage = route.query.page;
            const fetchTableHeader = {
                attribute: attributeData.value,
                sortable: sortableData.value,
            };

            fetchPostList(paginationPage, fetchTableHeader);
            current.value = parseInt(paginationPage);
        };

        const handleTableHeaderClick = async (e) => {
            const fetchTableHeader =
                postTablePageAdminStore.handleTableHeaderFunction(e);

            attributeData.value = fetchTableHeader.attribute;
            sortableData.value = fetchTableHeader.sortable;

            fetchPostList(null, fetchTableHeader);
        };

        const fetchPostList = async (
            paginationPage = null,
            fetchTableHeader = null
        ) => {
            try {
                const fetchColumnList =
                    postTablePageAdminStore.fetchPostColumns();

                const response = await postTablePageAdminStore.fetchPostList(
                    getAuthToken,
                    paginationPage,
                    fetchTableHeader
                );

                columns.value = fetchColumnList;
                totalPaginationNumber.value = response.data.last_page;
                pagination.value.rowsPerPage = response.data.per_page;

                const updatedData = response.result.map((item) => {
                    return {
                        ...item,
                        created_at: dayjs(item.created_at).format(
                            'YYYY-MM-DD HH:mm:ss'
                        ),
                    };
                });

                rows.value = updatedData;

                return response;
            } catch (error) {
                console.error('Error fetching post list:', error);
            }
        };

        fetchPostList();

        return {
            selected,
            columns,
            rows,
            status,
            current,
            attributeData,
            sortableData,
            totalPaginationNumber,
            pagination,
            fetchPagination,
            handleTableHeaderClick,
            getSelectedString() {
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

<style>
.posts-table .q-table__sort-icon {
    opacity: 1;
}

.q-table-custom-progress-bar {
    height: 0.75rem;
}

.q-table-label {
    color: var(--label-table-primary);
}

.q-table-edit-dropdown-list .q-item__section--main + .q-item__section--main {
    margin: 0 !important;
}

.posts-table .q-table__bottom .q-table__control:nth-of-type(3) {
    display: none;
}
</style>

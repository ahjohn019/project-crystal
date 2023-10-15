<template>
    <div class="row mt-5">
        <div class="col">
            <q-table
                flat
                bordered
                :rows="rows"
                :columns="columns"
                row-key="name"
                :selected-rows-label="getSelectedString"
                selection="multiple"
                v-model:selected="selected"
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
                <template v-slot:body-cell-name="props">
                    <q-td :props="props">
                        <div class="font-bold">{{ props.value }}</div>
                        <div class="q-table-label">Likes : 10</div>
                    </q-td>
                </template>
                <template v-slot:body-cell-popularity="props">
                    <q-td :props="props">
                        <div>
                            <span class="q-table-label">Score : </span>
                            <q-badge
                                color="positive"
                                style="font-weight: bold"
                                class="capitalize p-2 rounded"
                                :label="props.value"
                            />
                        </div>
                        <div>
                            <q-linear-progress
                                rounded
                                size="15px"
                                :value="progress"
                                class="q-mt-sm rounded q-table-custom-progress-bar progress-transition"
                            />
                        </div>
                    </q-td>
                </template>
                <template v-slot:body-cell-status="props">
                    <q-td :props="props">
                        <div class="flex">
                            <div>
                                <q-toggle v-model="status[props.row.name]" />
                            </div>
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
            <div class="q-mt-md">Selected: {{ JSON.stringify(selected) }}</div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue';

const columns = [
    {
        name: 'name',
        align: 'left',
        label: 'Posts',
        field: 'name',
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
        sortable: true,
    },
];

const rows = [
    {
        name: 'Frozen Yogurt',
        popularity: 'good',
        created_at: '2022-01-22',
        status: 'active',
    },
    {
        name: 'Ice cream sandwich',
        popularity: 'good',
        created_at: '2022-01-22',
        status: 'active',
    },
];

export default {
    setup() {
        const selected = ref([]);
        const progress = ref(0);
        const status = ref({});

        rows.forEach((row) => {
            status.value[row.name] = true;
        });

        const startInitialTransition = () => {
            const duration = 2000;
            const targetProgress = 0.5;
            const step = (targetProgress / duration) * 1000;

            let currentProgress = 0;

            const interval = setInterval(() => {
                if (currentProgress < targetProgress) {
                    progress.value = currentProgress;
                    currentProgress += step;
                } else {
                    progress.value = targetProgress;
                    clearInterval(interval);
                }
            }, 10);
        };

        onMounted(() => {
            startInitialTransition();
        });

        return {
            progress,
            selected,
            columns,
            rows,
            status,
            getSelectedString() {
                return selected.value.length === 0
                    ? ''
                    : `${selected.value.length} record${
                          selected.value.length > 1 ? 's' : ''
                      } selected of ${rows.length}`;
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
</style>

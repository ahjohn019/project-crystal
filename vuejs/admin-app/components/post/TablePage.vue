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
                        {{ props.value }}
                    </q-td>
                </template>
                <template v-slot:body-cell-popularity="props">
                    <q-td :props="props">
                        <div>
                            <q-badge color="purple" :label="props.value" />
                        </div>
                        <div>
                            <q-linear-progress
                                rounded
                                size="15px"
                                :value="progress"
                                class="q-mt-sm"
                                color="primary"
                            />
                        </div>
                    </q-td>
                </template>
            </q-table>
            <div class="q-mt-md">Selected: {{ JSON.stringify(selected) }}</div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

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
        name: 'status',
        align: 'left',
        label: 'Status',
        field: 'status',
        sortable: true,
    },
    {
        name: 'created_at',
        align: 'left',
        label: 'Created At',
        field: 'created_at',
        sortable: true,
    },
    { name: 'action', align: 'left', label: 'Action', field: 'action' },
];

const rows = [
    {
        name: 'Frozen Yogurt',
        popularity: 'good',
        status: 'active',
        created_at: '2022-01-22',
        action: '',
    },
    {
        name: 'Ice cream sandwich',
        popularity: 'good',
        status: 'active',
        created_at: '2022-01-22',
        action: '',
    },
];

export default {
    setup() {
        const selected = ref([]);
        const progress = 0.4;

        return {
            progress,
            selected,
            columns,
            rows,

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
</style>

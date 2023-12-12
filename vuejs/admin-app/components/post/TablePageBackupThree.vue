<template>
    <div class="q-pa-md">
        <q-table
            flat
            bordered
            ref="tableRef"
            title="Treats"
            :rows="rows"
            :columns="columns"
            row-key="id"
            v-model:pagination="pagination"
            :loading="loading"
            :filter="filter"
            binary-state-sort
            @request="onRequest"
            class="posts-table"
        >
            <template v-slot:top-right>
                <q-input
                    borderless
                    dense
                    debounce="300"
                    v-model="filter"
                    placeholder="Search"
                >
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </template>
        </q-table>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

const columns = [
    {
        name: 'desc',
        required: true,
        label: 'Dessert (100g serving)',
        align: 'left',
        field: (row) => row.name,
        format: (val) => `${val}`,
        sortable: true,
    },
    {
        name: 'calories',
        align: 'center',
        label: 'Calories',
        field: 'calories',
        sortable: true,
    },
    { name: 'fat', label: 'Fat (g)', field: 'fat', sortable: true },
    { name: 'carbs', label: 'Carbs (g)', field: 'carbs', sortable: true },
    { name: 'protein', label: 'Protein (g)', field: 'protein', sortable: true },
    { name: 'sodium', label: 'Sodium (mg)', field: 'sodium', sortable: true },
    {
        name: 'calcium',
        label: 'Calcium (%)',
        field: 'calcium',
        sortable: true,
        sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
    },
    {
        name: 'iron',
        label: 'Iron (%)',
        field: 'iron',
        sortable: true,
        sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
    },
];

const originalRows = [
    {
        id: 1,
        name: 'Frozen Yogurt',
        calories: 159,
        fat: 6.0,
        carbs: 24,
        protein: 4.0,
        sodium: 87,
        calcium: '14%',
        iron: '1%',
    },
    {
        id: 2,
        name: 'Ice cream sandwich',
        calories: 237,
        fat: 9.0,
        carbs: 37,
        protein: 4.3,
        sodium: 129,
        calcium: '8%',
        iron: '1%',
    },
    {
        id: 3,
        name: 'Eclair',
        calories: 262,
        fat: 16.0,
        carbs: 23,
        protein: 6.0,
        sodium: 337,
        calcium: '6%',
        iron: '7%',
    },
    {
        id: 4,
        name: 'Cupcake',
        calories: 305,
        fat: 3.7,
        carbs: 67,
        protein: 4.3,
        sodium: 413,
        calcium: '3%',
        iron: '8%',
    },
    {
        id: 5,
        name: 'Gingerbread',
        calories: 356,
        fat: 16.0,
        carbs: 49,
        protein: 3.9,
        sodium: 327,
        calcium: '7%',
        iron: '16%',
    },
];

export default {
    setup() {
        const tableRef = ref();
        const rows = ref([]);
        const filter = ref('');
        const loading = ref(false);
        const pagination = ref({
            sortBy: 'desc',
            descending: false,
            page: 1,
            rowsPerPage: 3,
            rowsNumber: 10,
        });

        // emulate ajax call
        // SELECT * FROM ... WHERE...LIMIT...
        function fetchFromServer(startRow, count, filter, sortBy, descending) {
            const data = filter
                ? originalRows.filter((row) => row.name.includes(filter))
                : originalRows.slice();

            // handle sortBy
            if (sortBy) {
                const sortFn =
                    sortBy === 'desc'
                        ? descending
                            ? (a, b) =>
                                  a.name > b.name ? -1 : a.name < b.name ? 1 : 0
                            : (a, b) =>
                                  a.name > b.name ? 1 : a.name < b.name ? -1 : 0
                        : descending
                        ? (a, b) =>
                              parseFloat(b[sortBy]) - parseFloat(a[sortBy])
                        : (a, b) =>
                              parseFloat(a[sortBy]) - parseFloat(b[sortBy]);
                data.sort(sortFn);
            }

            return data.slice(startRow, startRow + count);
        }

        // emulate 'SELECT count(*) FROM ...WHERE...'
        function getRowsNumberCount(filter) {
            if (!filter) {
                return originalRows.length;
            }
            let count = 0;
            originalRows.forEach((treat) => {
                if (treat.name.includes(filter)) {
                    ++count;
                }
            });
            return count;
        }

        function onRequest(props) {
            const { page, rowsPerPage, sortBy, descending } = props.pagination;
            const filter = props.filter;

            loading.value = true;

            // emulate server
            setTimeout(() => {
                // update rowsCount with appropriate value
                pagination.value.rowsNumber = getRowsNumberCount(filter);

                // get all rows if "All" (0) is selected
                const fetchCount =
                    rowsPerPage === 0
                        ? pagination.value.rowsNumber
                        : rowsPerPage;

                // calculate starting row of data
                const startRow = (page - 1) * rowsPerPage;

                // fetch data from "server"
                const returnedData = fetchFromServer(
                    startRow,
                    fetchCount,
                    filter,
                    sortBy,
                    descending
                );

                // clear out existing data and add new
                rows.value.splice(0, rows.value.length, ...returnedData);

                // don't forget to update local pagination object
                pagination.value.page = page;
                pagination.value.rowsPerPage = rowsPerPage;
                pagination.value.sortBy = sortBy;
                pagination.value.descending = descending;

                // ...and turn of loading indicator
                loading.value = false;
            }, 1500);
        }

        onMounted(() => {
            // get initial data from server (1st page)
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
        };
    },
};
</script>

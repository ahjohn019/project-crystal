<template>
    <div
        class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3 grid-style-transition"
        :style="property.selected ? 'transform: scale(0.95);' : ''"
    >
        <q-card
            bordered
            flat
            :class="
                property.selected
                    ? $q.dark.isActive
                        ? 'bg-grey-9'
                        : 'bg-grey-2'
                    : ''
            "
        >
            <q-card-section>
                <q-checkbox
                    dense
                    v-model="property.selected"
                    :label="property.row.name"
                />
            </q-card-section>
            <q-separator />
            <q-list dense>
                <q-item
                    v-for="col in property.cols.filter(
                        (col) => col.name !== 'desc'
                    )"
                    :key="col.name"
                >
                    <q-item-section>
                        <q-item-label style="font-size: 12px">{{
                            col.label
                        }}</q-item-label>
                    </q-item-section>
                    <q-item-section
                        side
                        class="text-right"
                        style="max-width: 200px"
                    >
                        <q-item-label caption v-if="col.name == 'status'">
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
                                        <q-list
                                            class="q-table-edit-dropdown-list"
                                        >
                                            <q-item
                                                clickable
                                                :to="
                                                    '/posts/view/' +
                                                    property.row.id
                                                "
                                            >
                                                <q-item-section>
                                                    <q-icon name="visibility" />
                                                </q-item-section>
                                                <q-item-section>
                                                    <q-item-label
                                                        >View
                                                    </q-item-label>
                                                </q-item-section>
                                            </q-item>

                                            <q-item
                                                clickable
                                                :to="{
                                                    name: 'posts.form',
                                                    query: {
                                                        type: 'edit',
                                                        id: property.row.id,
                                                    },
                                                }"
                                            >
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
                                                    handlePostDelete(
                                                        property.row.id
                                                    )
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
                        </q-item-label>
                        <q-item-label caption v-else>
                            {{ fetchPostValue(col, property) }}
                        </q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card>
    </div>
</template>

<script>
export default {
    props: {
        property: Object,
    },
    setup(props, { emit }) {
        const fetchPostValue = (col, property) => {
            const { name, value } = col;

            if (name === 'popularity') {
                return property.row.popularity_percentage + '%';
            }
            return value;
        };

        const handlePostDelete = (value) => {
            emit('postDelete', value);
        };

        return {
            fetchPostValue,
            handlePostDelete,
        };
    },
};
</script>

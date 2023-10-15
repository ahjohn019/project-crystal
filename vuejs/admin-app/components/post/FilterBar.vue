<template>
    <div class="row p-2 bg-white mt-5">
        <div class="col col-md-6 col-lg-9 filter-posts-search-bar">
            <q-input outlined dense label="Search"> </q-input>
        </div>
        <div class="col col-md-2 col-lg-1">
            <q-btn-dropdown
                label="Filters"
                class="filter-posts-bar"
                dropdown-icon="expand_more"
            >
                <q-list>
                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Photos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Videos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Articles</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-btn-dropdown>
        </div>
        <div class="col col-md-2 col-lg-1">
            <q-btn-dropdown
                class="filter-posts-bar"
                dropdown-icon="expand_more"
                label="Category"
            >
                <q-list>
                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Photos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Videos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Articles</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-btn-dropdown>
        </div>
        <div class="col col-md-2 col-lg-1">
            <q-btn-dropdown
                class="filter-posts-bar"
                dropdown-icon="expand_more"
                label="Latest"
            >
                <q-list>
                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Photos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Videos</q-item-label>
                        </q-item-section>
                    </q-item>

                    <q-item clickable>
                        <q-item-section>
                            <q-item-label>Articles</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-btn-dropdown>
        </div>
    </div>
</template>

<style>
.filter-posts-bar {
    color: #11142d;
    font-weight: 700;
    text-transform: none;
}

.filter-posts-bar .q-btn-dropdown__arrow {
    color: #9a9ab0;
}

.filter-posts-bar .q-btn__content > span {
    width: 75px;
    text-align: left;
}

.filter-posts-search-bar .q-field__control {
    color: var(--primary);
}
</style>

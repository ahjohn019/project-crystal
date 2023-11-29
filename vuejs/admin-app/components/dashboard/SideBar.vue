<template>
    <div style="max-width: 250px; max-height: 0">
        <q-list padding class="border-r side-bar-container bg-white fixed">
            <template v-for="(sideBarItem, index) in sideBarList" :key="index">
                <q-item
                    clickable
                    dense
                    @click="handleItemClick(sideBarItem)"
                    :to="sideBarItem.route"
                    v-ripple
                    class="m-4 rounded"
                >
                    <q-item>
                        <q-item-section avatar>
                            <q-icon :name="sideBarItem.icon" />
                        </q-item-section>
                        <q-item-section class="font-bold">
                            <q-item-label class="font-bold">
                                {{ sideBarItem.text }}</q-item-label
                            >
                        </q-item-section>
                    </q-item>
                </q-item>
            </template>
        </q-list>
    </div>
</template>

<script>
import { ref } from 'vue';

const sideBarList = [
    {
        icon: 'grid_view',
        title: 'dashboard',
        text: 'Dashboard',
        route: '/',
    },
    {
        icon: 'equalizer',
        title: 'statistics',
        text: 'Statistics',
        route: null,
    },
    {
        icon: 'description',
        title: 'posts',
        text: 'Posts',
        route: '/posts',
    },
    {
        icon: 'tune',
        title: 'settings',
        text: 'Settings',
        route: null,
    },
];

export default {
    setup() {
        const link = ref('dashboard');

        function handleItemClick(sideBarItem) {
            link.value = sideBarItem.title;
        }

        return {
            link,
            sideBarList,

            handleItemClick,
        };
    },
};
</script>

<style>
.side-bar-container {
    height: calc(100vh - 75px);
}

.side-bar-container .q-item.q-router-link--active {
    color: white;
    background: var(--primary);
}
</style>

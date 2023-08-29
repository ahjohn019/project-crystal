<template>
    <div style="max-width: 250px; max-height: 0">
        <q-list padding class="border-r side-bar-container bg-white">
            <template v-for="(sideBarItem, index) in sideBarList" :key="index">
                <q-item
                    clickable
                    dense
                    :active="link === sideBarItem.title"
                    @click="link = sideBarItem.title"
                    active-class="admin-side-bar"
                    v-ripple
                    class="m-4 rounded"
                >
                    <q-item>
                        <q-item-section avatar>
                            <q-icon :name="sideBarItem.icon" />
                        </q-item-section>
                        <q-item-section class="font-bold">
                            <q-item-label class="font-bold">{{
                                sideBarItem.text
                            }}</q-item-label>
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
    },
    {
        icon: 'equalizer',
        title: 'statistics',
        text: 'Statistics',
    },
    {
        icon: 'shopping_bag',
        title: 'my-products',
        text: 'My Products',
    },
    {
        icon: 'tune',
        title: 'settings',
        text: 'Settings',
    },
];

export default {
    setup() {
        return {
            link: ref('dashboard'),
            sideBarList,
        };
    },
};
</script>

<style>
.side-bar-container {
    height: calc(100vh - 75px);
}

.admin-side-bar {
    color: white;
    background: #5541d7;
}
</style>

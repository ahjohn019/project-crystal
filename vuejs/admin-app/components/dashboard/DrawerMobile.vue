<template>
    <q-toolbar class="justify-end">
        <q-btn flat @click="toggleDrawerMobile" round dense icon="menu" />
    </q-toolbar>

    <q-drawer
        v-model="toggleDrawer"
        :width="200"
        :breakpoint="500"
        overlay
        bordered
        side="right"
        :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'"
    >
        <q-scroll-area class="fit">
            <q-list>
                <q-item>
                    <q-item-section>
                        <q-input outlined dense label="Search">
                            <template v-slot:append>
                                <q-icon name="search" />
                            </template>
                        </q-input>
                    </q-item-section>
                </q-item>
                <q-item clickable v-ripple>
                    <q-item-section class="items-center">
                        <q-avatar size="100px">
                            <img src="https://cdn.quasar.dev/img/avatar.png" />
                        </q-avatar>
                    </q-item-section>
                </q-item>
                <q-item clickable v-ripple>
                    <q-item-section class="items-center">
                        <div class="font-bold">Shoo Bro Thoo</div>
                        <div class="lowercase text-gray-500">
                            shoobro@email.com
                        </div>
                    </q-item-section>
                </q-item>
                <template v-for="(menuItem, index) in menuList" :key="index">
                    <q-item
                        clickable
                        :active="menuItem.label === 'Outbox'"
                        v-ripple
                    >
                        <q-item-section avatar>
                            <q-icon :name="menuItem.icon" />
                        </q-item-section>
                        <q-item-section>
                            {{ menuItem.label }}
                        </q-item-section>
                    </q-item>
                    <q-separator
                        :key="'sep' + index"
                        v-if="menuItem.separator"
                    />
                </template>
            </q-list>
        </q-scroll-area>
    </q-drawer>
</template>

<script>
import { ref } from 'vue';

const menuList = [
    {
        icon: 'grid_view',
        label: 'Dashboard',
        separator: false,
    },
    {
        icon: 'equalizer',
        label: 'Statistics',
        separator: false,
    },
    {
        icon: 'shopping_bag',
        label: 'My Products',
        separator: true,
    },
    {
        icon: 'tune',
        label: 'Settings',
        separator: false,
    },
];

export default {
    setup() {
        const toggleDrawer = ref(false);

        // Expose the parent method
        const toggleDrawerMobile = () => {
            toggleDrawer.value = !toggleDrawer.value;
        };

        return {
            toggleDrawerMobile,
            toggleDrawer,
            menuList,
        };
    },
};
</script>

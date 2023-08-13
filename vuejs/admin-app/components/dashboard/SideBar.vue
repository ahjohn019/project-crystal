<template>
    <div style="max-width: 250px">
        <q-list padding class="border-r side-bar-container">
            <q-item
                clickable
                dense
                :active="link === 'dashboard'"
                @click="link = 'dashboard'"
                active-class="admin-side-bar"
                v-ripple
                class="m-4 rounded"
            >
                <q-item>
                    <q-item-section avatar>
                        <q-icon name="grid_view" />
                    </q-item-section>
                    <q-item-section class="font-bold">
                        <q-item-label class="font-bold">Dashboard</q-item-label>
                    </q-item-section>
                </q-item>
            </q-item>

            <q-item
                clickable
                dense
                :active="link === 'statistics'"
                @click="link = 'statistics'"
                active-class="admin-side-bar"
                v-ripple
                class="m-4 rounded"
            >
                <q-item>
                    <q-item-section avatar>
                        <q-icon name="equalizer" />
                    </q-item-section>
                    <q-item-section class="font-bold">
                        <q-item-label class="font-bold"
                            >Statistics</q-item-label
                        >
                    </q-item-section>
                </q-item>
            </q-item>

            <q-item
                clickable
                dense
                :active="link === 'my-products'"
                @click="link = 'my-products'"
                active-class="admin-side-bar"
                v-ripple
                class="m-4 rounded"
            >
                <q-item>
                    <q-item-section avatar>
                        <q-icon name="shopping_bag" />
                    </q-item-section>
                    <q-item-section class="font-bold">
                        <q-item-label class="font-bold"
                            >My Products</q-item-label
                        >
                    </q-item-section>
                </q-item>
            </q-item>
            <q-item
                clickable
                dense
                :active="link === 'settings'"
                @click="link = 'settings'"
                active-class="admin-side-bar"
                v-ripple
                class="m-4 rounded"
            >
                <q-item>
                    <q-item-section avatar>
                        <q-icon name="tune" />
                    </q-item-section>
                    <q-item-section class="font-bold">
                        <q-item-label class="font-bold">Settings</q-item-label>
                    </q-item-section>
                </q-item>
            </q-item>
        </q-list>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        return {
            link: ref('dashboard'),
        };
    },
};
</script>

<style>
.side-bar-container {
    height: calc(100vh - 72px);
}

.admin-side-bar {
    color: white;
    background: #5541d7;
}
</style>

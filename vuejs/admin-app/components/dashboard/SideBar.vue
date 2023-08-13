<template>
    <div style="max-width: 350px">
        <q-list bordered padding class="side-bar-container">
            <q-item clickable v-ripple>
                <q-item-section class="q-pa-md">
                    <div class="row items-center">
                        <div class="col col-md-4">
                            <q-avatar size="75px" rounded>
                                <img
                                    src="https://cdn.quasar.dev/img/avatar.png"
                                />
                            </q-avatar>
                        </div>
                        <div class="col">
                            <div class="text-xl font-bold">Broto Store</div>
                            <div>Verified</div>
                        </div>
                    </div>
                </q-item-section>
            </q-item>
            <q-separator />

            <q-item clickable v-ripple>
                <q-item>
                    <q-item-section avatar>
                        <q-icon name="grid_view" />
                    </q-item-section>
                    <q-item-section class="font-bold">
                        <q-item-label class="font-bold">Dashboard</q-item-label>
                    </q-item-section>
                </q-item>
            </q-item>

            <q-item clickable v-ripple>
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

            <q-item clickable v-ripple>
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
            <q-item clickable v-ripple>
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

<style>
.side-bar-container {
    height: calc(100vh - 72px);
}
</style>

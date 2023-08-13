<template>
    <q-header elevated class="bg-white text-black py-2">
        <div class="row items-center mx-4 md:mx-10">
            <div class="col col-lg-2 text-sm md:text-2xl lg:text-center ml-4">
                Admin Panel
            </div>

            <div class="col col-lg-8 col-md-5 nav-profile-details">
                <q-input outlined dense label="Label">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </div>

            <div class="col nav-profile-details">
                <div class="row items-center">
                    <div class="col col-md-3 flex justify-end">
                        <q-avatar>
                            <img src="https://cdn.quasar.dev/img/avatar.png" />
                        </q-avatar>
                    </div>
                    <div class="col">
                        <q-btn-dropdown
                            class="text-black"
                            color="white"
                            dropdown-icon="expand_more"
                        >
                            <template v-slot:label>
                                <div class="row items-center no-wrap">
                                    <div class="col text-center">
                                        <div class="font-bold">
                                            Shoo Bro Thoo
                                        </div>
                                        <div class="lowercase text-gray-500">
                                            shoobro@email.com
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <q-list>
                                <q-item clickable v-close-popup>
                                    <q-item-section>
                                        <q-item-label>Photos</q-item-label>
                                    </q-item-section>
                                </q-item>
                                <q-item clickable v-close-popup>
                                    <q-item-section>
                                        <q-item-label>Videos</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </div>
                </div>
            </div>

            <div class="col nav-profile-sidebar">
                <DrawerMobile />
            </div>
        </div>
    </q-header>
</template>

<script>
import DrawerMobile from '@admin/components/dashboard/DrawerMobile.vue';

export default {
    components: {
        DrawerMobile,
    },
};
</script>

<style>
.q-btn:before {
    box-shadow: none !important;
}

.q-btn-dropdown__arrow-container {
    font-size: 32px !important;
}

@media (max-width: 768px) {
    .nav-profile-details {
        display: none;
    }

    .nav-profile-sidebar {
        display: block;
    }
}

@media (min-width: 769px) {
    .nav-profile-details {
        display: block;
    }

    .nav-profile-sidebar {
        display: none;
    }
}
</style>

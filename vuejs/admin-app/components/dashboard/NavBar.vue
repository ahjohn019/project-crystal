<template>
    <q-header class="border-b bg-white text-black py-2">
        <div class="row items-center mx-4 md:mx-10">
            <div class="col-2 col-lg-1 text-sm md:text-2xl lg:text-center ml-4">
                <img :src="mainLogo" alt="" width="100" class="mx-auto" />
            </div>
            <div class="col col-lg-9 col-md-5 nav-profile-details">
                <q-input
                    outlined
                    dense
                    label="Search"
                    v-model="searchKeywordAdmin"
                >
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
                                            {{ adminProfileData.name }}
                                        </div>
                                        <div class="lowercase text-gray-500">
                                            {{ adminProfileData.email }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <q-list>
                                <q-item
                                    v-for="item in navBarDropDown"
                                    :key="item"
                                    clickable
                                    v-close-popup
                                    @click="handleDropdownMenu(item.handler)"
                                >
                                    <q-item-section>
                                        <q-item-label>{{
                                            item.label
                                        }}</q-item-label>
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
import { useAdminAuthStore } from '@shared_admin/base/auth.js';
import { onMounted, ref } from 'vue';

export default {
    components: {
        DrawerMobile,
    },

    setup() {
        const adminStore = useAdminAuthStore();
        const getAuthToken = adminStore.fetchSessionToken();
        const adminProfileData = ref({
            email: '',
            name: '',
        });
        const navBarDropDown = ref([
            { label: 'Log Out', value: 'logout', handler: 'handlerLogout' },
        ]);
        const searchKeywordAdmin = ref('');

        const handleLogout = async () => {
            try {
                await adminStore.handleLogout(getAuthToken);
            } catch (error) {
                console.log(error);
            }
        };

        const fetchProfile = async () => {
            try {
                const fetchAdminProfile = await adminStore.fetchProfile(
                    getAuthToken
                );

                adminProfileData.value.email = fetchAdminProfile.email;
                adminProfileData.value.name = fetchAdminProfile.name;
            } catch (error) {
                console.error('Error fetching user profile:', error);
            }
        };

        const handleDropdownMenu = (funcName) => {
            const functionList = {
                handlerLogout: handleLogout,
            };

            const selectedFunction = functionList[funcName];

            if (selectedFunction) {
                selectedFunction();
            }
        };

        onMounted(() => {
            fetchProfile();
        });

        return {
            handleLogout,
            adminProfileData,
            navBarDropDown,
            handleDropdownMenu,
            searchKeywordAdmin,
        };
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

.nav-profile-details .q-field__control {
    color: var(--primary);
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

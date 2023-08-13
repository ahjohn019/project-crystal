<template>
    <q-layout view="hHh Lpr lff" container style="height: 100vh">
        <nav-bar />
        <q-page-container>
            <q-page>
                <side-bar />
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<script>
import NavBar from '@admin/components/dashboard/NavBar.vue';
import SideBar from '@admin/components/dashboard/SideBar.vue';

export default {
    components: {
        NavBar,
        SideBar,
    },
};
</script>

import { createWebHistory, createRouter } from 'vue-router';
import * as AdminDashboard from '../modules/dashboard/router';

const routes = [
    {
        path: '/',
        component: AdminDashboard.MainPage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

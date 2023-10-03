import { createWebHistory, createRouter } from 'vue-router';
import * as AdminDashboard from '../modules/dashboard/router';
import * as LoginDashboard from '../modules/login/router';
import { useAdminAuthStore } from '@shared_admin/base/auth.js';

const routes = [
    {
        path: '/',
        component: AdminDashboard.MainPage,
        meta: { requiresAuth: true },
        name: 'home',
    },
    {
        path: '/login',
        component: LoginDashboard.LoginPage,
        meta: { requiresAuth: false },
        name: 'login',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const adminAuthStore = useAdminAuthStore();
    const getAuthToken = adminAuthStore.fetchSessionToken();

    if (to.path != '/login' && getAuthToken == null && to.meta.requiresAuth) {
        next('/login');
    } else {
        next();
    }
});

export default router;

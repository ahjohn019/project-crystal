import { createWebHistory, createRouter } from 'vue-router';
import * as Master from '../modules/main/router';

const routes = [
    {
        path: '/',
        component: Master.MainPage,
        meta: { requiresAuth: false },
        name: 'main',
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    next();
});

export default router;

import { createRouter, createWebHashHistory } from 'vue-router';
import mainPage from '../pages/main.vue';
import aboutPage from '../pages/about.vue';

const routes = [
    {
        path: '/',
        name: 'Index',
        component: mainPage,
    },
    {
        path: '/about',
        name: 'About',
        component: aboutPage,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
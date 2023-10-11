import './bootstrap';

import {createApp} from 'vue'

import App from './Components/App.vue'

import {createRouter, createWebHistory} from 'vue-router'

const app = createApp(App);

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./Components/Home.vue')
        },
        {
            path: '/machinetest/task',
            component: () => import('./Components/MachineTest.vue')
        }
    ],
})
app.use(router);
app.mount("#app");
import { createApp,ref }  from 'vue';
import App from '../App.vue';
import { createRouter, createWebHistory } from "vue-router";
import { useRouter } from 'vue-router';
import '../bootstrap';
import collapse from "bootstrap/js/src/collapse";
import routes from '../router';
import '@mdi/font/css/materialdesignicons.css'
import PrimeVue from "primevue/config";
import "primevue/resources/themes/lara-light-indigo/theme.css";
import "primevue/resources/primevue.min.css";
import { getCurrentUserRole } from '../admin/Services/auth';

import LoginForm from '../client/components/LoginForm.vue';
import RegisterForm from '../client/components/RegisterForm.vue';

const router = createRouter({
    history: createWebHistory(),
    routes
})
const message = ref('');

router.beforeEach((to, from, next) => {
    const requiresAdmin = to.matched.some((route) => route.meta.requiresAdmin);
    const isAdmin = getCurrentUserRole() === 'admin';

    if (requiresAdmin && !isAdmin) {
        // User is not an admin, redirect to login or show access denied page
        next({ path: '/login' });
        message.value = 'Access denied. You must be an admin to access this page.';
    } else {
        // Allow the navigation
        next();
        message.value = ''; // Clear the message
    }
});

const admin = createApp(App);
admin.use(router);
admin.use(PrimeVue)
admin.provide('message', message); // Provide the message to child components
admin.mount('#admin');

admin.component('login-form', LoginForm);
admin.component('register-form', RegisterForm);

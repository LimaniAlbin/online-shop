import { createApp }  from 'vue';
import App from '../App.vue';
import { createRouter, createWebHistory } from "vue-router";
import '../bootstrap';
import collapse from "bootstrap/js/src/collapse";
import 'bootstrap/dist/js/bootstrap.bundle.min'
import routes from '../router';
import '@mdi/font/css/materialdesignicons.css'
import PrimeVue from "primevue/config";
import "primevue/resources/themes/lara-light-indigo/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";


import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegisterForm.vue';

const router = createRouter({
    history: createWebHistory(),
    routes
})


const app = createApp(App)
app.use(router)
    .mount('#client')

app.use(PrimeVue)

app.component('login-form', LoginForm);
app.component('register-form', RegisterForm);

import Home from './Home.vue';
import Products from './Products/Products.vue';
import Dashboard from './Dashboard.vue';
import Login from '../client/components/LoginForm.vue';
import Register from '../client/components/RegisterForm.vue';
import Brands from './Brands/Brands.vue';
import User from './Users/User.vue';

const DashboardRoutes = [
    {
        path: '',
        component: Dashboard,
    },
    {
        path: '/products',
        component: Products,
    },
    {
        path: '/brands',
        component: Brands,
    },
    {
        path: '/user',
        component: User,
    },
];

const routes = [
    {
        path: '/admin',
        component: Home,
        children: DashboardRoutes,
    },
    {
        path: '/login',
        component: Login,
    },
    {
        path: '/register',
        component: Register,
    },
];

export default routes;

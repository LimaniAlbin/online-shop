import Home from './client/Home.vue'
import Index from "./client/index.vue";
import LoginForm from "./client/components/LoginForm.vue";
import RegisterForm from "./client/components/RegisterForm.vue";
import Admin from './admin/Home.vue'
import Dashboard from "./admin/Dashboard.vue";
import Products from "./admin/Products/Products.vue";
import Brands from "./admin/Brands/Brands.vue";
import Categories from "./admin/Categories/Categories.vue";
import Shop from './client/Shop/Products.vue'
import SingleProduct from  './client/Shop/SingleProduct.vue';
import Users from './admin/Users/User.vue';

const AdminSidebarRoutes = [
    {
        path: '',
        component: Dashboard
    },
    {
        path: '/products', // Add leading slash to the child paths
        component: Products
    },
    {
        path: '/brands', // Add leading slash to the child paths
        component: Brands
    },
    {
        path: '/categories',
        component: Categories
    },
    {
        path: '/user',
        component: Users,

    },
]
// const AdminRoutes = [
//     {
//         path: '',
//         component: Admin,  // The default route
//         children: AdminSidebarRoutes
//     },
//
// ]

const ClientRoutes = [
    {
        path: '',
        component: Index
    },
    {
        path: '/shop',
        component: Shop
    },
    {
        path: '/shop/:id',
        component: SingleProduct,
        props: true
    },
]

const routes = [
    {
        path: '/',
        component: Home,
        children: ClientRoutes
    },
    {
        path: '/admin',
        component: Admin,
        children: AdminSidebarRoutes,
        meta: { requiresAdmin: true }
    },
    {
        path: '/login',
        component: LoginForm
    },
    {
        path: '/register',
        component: RegisterForm
    },
];

export default routes;

import { createRouter, createWebHistory } from "vue-router";

import Login from './components/Login.vue';
import Register from './components/Register.vue';
import CustomerPublic from './components/CustomerPublic.vue';
import PageNotFound from './components/PageNotFound.vue'
import Customers from './components/Customers.vue';
import AddCustomer from './components/AddCustomer.vue';
import Editustomer from './components/EditCustomer.vue';
import { store } from '@/store';

const routes = [
    {
        name: 'home',
        path: '/',
        component: CustomerPublic
    },
    {
        name: 'pageNotFound',
        path: '/:pathMatch(.*)*',
        component: PageNotFound
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'customers',
        path: '/customers',
        component: Customers,
        meta: {
            requireAuth: true
        }
    },
    {
        name: 'addCustomer',
        path: '/customers/add',
        component: AddCustomer,
        meta: {
            requireAuth: true
        }
    },
    {
        name: 'editCustomer',
        path: '/customers/edit/:id',
        component: Editustomer,
        meta: {
            requireAuth: true
        },
        props:true,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from) => {

    if (to.meta.requireAuth && !store.isLoggedIn) {
        router.push({ name: 'login' });
    }

    // if (!to.meta.requireAuth && store.isLoggedIn){
    //     router.push({ name: 'customers' });
    // }


});

export default router;
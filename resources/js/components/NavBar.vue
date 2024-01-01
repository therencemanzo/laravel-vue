<template>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo.svg"
                    alt="Bootstrap" width="30" height="24"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <router-link :to="{ name: 'home' }" class="nav-link"
                            :class="{ active: route.name == 'home' }">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="!store.isLoggedIn">
                        <router-link :to="{ name: 'login' }" class="nav-link"
                            :class="{ active: route.name == 'login' }">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="!store.isLoggedIn">
                        <router-link :to="{ name: 'register' }" class="nav-link"
                            :class="{ active: route.name == 'register' }">Register</router-link>
                    </li>
                    <li class="nav-item" v-if="store.isLoggedIn">
                        <router-link :to="{ name: 'customers' }" class="nav-link"
                            :class="{ active: route.name == 'customers' }" href="#">Customers</router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="store.isLoggedIn">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ store.user.name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" @click="handleLogout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { store } from '@/store';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import router from '@/router';
import axios from 'axios';

const route = useRoute();

onMounted(async () => {

    getUser();
});

const getUser = async () => {

    try {

        let response = await axios.get('user');
        store.setUser(response.data);

    } catch (err) {
        store.clearUser();
        store.logout();
    }
}

const handleLogout = async () => {

    try {
        let response = await axios.post('logout');
        localStorage.removeItem('access_token');
        store.clearUser();
        store.logout();
        router.push({ name: 'login' });
    } catch (err) {

        localStorage.removeItem('access_token');
        //store.clearUser();
        //store.logout();
        //router.push({ name: 'login' });
    }
}


</script>
<template>
    <div id="app">
        <div class="overlay" v-if="store.loads">
            <div class="d-flex justify-content-center">
                <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem; z-index: 20;">
                </div>
            </div>
        </div>
        <NavBar />
        <RouterView />
    </div>
</template>


<script setup>

import NavBar from './components/NavBar.vue';
import CustomerPublic from './components/CustomerPublic.vue';
import { store } from '@/store';


</script>
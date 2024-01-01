<template>
    <div class="container">
        <form class="m-auto col-5 mt-4 border border-secondary p-4" @submit.prevent="handleRegister">
            <h4>REGISTER</h4>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="form.name" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-danger" v-if="errors.name">{{ errors.name[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email"  v-model="form.email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password"  v-model="form.password">
                <div id="emailHelp" class="form-text text-danger" v-if="errors.password">{{ errors.password[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password-confirm" v-model="form.confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script setup>

import { ref } from 'vue';
import axios from 'axios';
import router from '@/router';
import { store } from '@/store';

const form = ref({
    email: '',
    password: '',
    name : '',
    confirm_password: ''
});

const invalidCredentialsError = ref('');
const errors = ref({
    name : '',
    email: '',
    password: '',
});

const handleRegister = async () => {

    try {
        let response = await axios.post('register', {
            email: form.value.email,
            password: form.value.password,
            name: form.value.name,
            password_confirmation: form.value.confirm_password
        });

        localStorage.setItem('access_token', response.data.access_token);

        await store.login();
        await store.setUser(response.data.data);
        
        router.push({ name: 'customers' });

    } catch (error) {

        if (error.response.status === 401) {

            invalidCredentialsError.value = error.response.data.message;

            return;
        }

        errors.value = error.response.data.errors;

    }
}
</script>
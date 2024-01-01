<template>
    <div class="container">
        <form class="m-auto col-5 mt-4 border border-secondary p-4" @submit.prevent="handleLogin">
            <h4>Login</h4>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="invalidCredentialsError">
                 {{ invalidCredentialsError }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    v-model="form.email">
                <div id="emailHelp" class="form-text text-danger" v-if="errors">{{ errors.email[0] }}</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" v-model="form.password">
                <div id="emailHelp" class="form-text text-danger" v-if="errors">{{ errors.password[0] }}</div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
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
    password: ''
});

const invalidCredentialsError = ref('');
const errors = ref();

const handleLogin = async () => {

    try {
        let response = await axios.post('login', {
            email: form.value.email,
            password: form.value.password
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
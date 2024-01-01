<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 m-auto">
                <h2>Add Customer</h2>
                <div class="alert alert-success" role="alert" v-if="sucess">
                    Succesfully added.
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" v-model="customer.name">
                        <div id="emailHelp" class="form-text text-danger" v-if="errors">{{ errors.name[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" v-model="customer.email">
                        <div id="emailHelp" class="form-text text-danger" v-if="errors">{{ errors.email[0] }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visibility</label>
                        <select class="form-select" v-model="customer.visibility">
                            <option value="1" selected>Private</option>
                            <option value="0">Public</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" v-model="customer.phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" v-model="customer.address">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import router from '@/router';

const customer = ref({
    'visibility' : 1
});
const errors = ref();
const sucess = ref(false);

const handleSubmit = async () => {

    try {
        let response = await axios.post('customers', {
            'name': customer.value.name,
            'email': customer.value.email,
            'phone': customer.value.phone,
            'address': customer.value.address,
            'visibility': customer.value.visibility
        });
        customer.value = [];
        sucess.value = true;

        setTimeout(() => router.push({ name: 'customers' }), 1500);


    } catch (error) {
        errors.value = error.response.data.errors;
    }
};


</script>
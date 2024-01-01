<template>
    <div class="container">
        <div class="row mt-5">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-8 mt-auto">
                    <div class="input-group">
                        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" v-model.lazy="searchQuery" />
                        <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init
                            @click="handleSearch()">search</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Customer List


                        <router-link type="button" class="btn btn-outline-primary" :to="{ name: 'addCustomer' }">Add
                            New</router-link>
                    </h5>
                    <table class="table table-striped border mt-3">
                        <thead>
                            <tr>
                                <th scope="col" width="20%">Name</th>
                                <th scope="col">Details</th>
                                <th scope="col" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers" :key="customer" v-if="customers.length > 0">
                                <td>{{ customer.name }}</td>
                                <td>
                                    <a class="text-primary">{{ customer.email }}</a>
                                    <br>
                                    {{ customer.phone }}
                                    <p>
                                        {{ customer.address }}
                                    </p>
                                    <div v-if="store.user.is_admin == 1">
                                        <hr>
                                        <p>
                                            <small v-if="store.user.name != customer.added_by.name">added by: <span
                                                    class="text-primary">{{ customer.added_by.name }} ({{
                                                        customer.added_by.email }} )</span></small>
                                            <small v-else>You added this</small>
                                        </p>

                                    </div>

                                </td>
                                <td>
                                    <router-link class="btn btn-outline-warning btn-sm"
                                        :to="{ name: 'editCustomer', params: { id: customer.id } }"> Edit </router-link> |
                                    <button class="btn btn-sm btn-outline-danger" @click="handleDelete(customer.id)"> Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="3"> no records</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="btn-group float-end" role="group" v-if="customers.length > 0">
                        <button type="button" class="btn btn-outline-primary" @click="handlePrev"
                            :disabled="paginationButton.prev == null">Prev</button>
                        <button type="button" class="btn btn-outline-primary" disabled>{{ page }}</button> 
                        
                        <button type="button" class="btn btn-outline-primary" @click="handleNext"
                            :disabled="paginationButton.next == null">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, watchEffect } from 'vue';
import { store } from '@/store';
import Swal from 'sweetalert2';


const customers = ref([]);
const page = ref(1);
const paginationButton = ref();
const searchQuery = ref('');
const searchQueryForRequest = ref('');
const draw = ref(1);

watchEffect(async () => {
    try {
        store.showLoader();
        let response = await axios.get(`customers?page=${page.value}&q=${searchQueryForRequest.value}&draw=${draw.value}`);
        customers.value = response.data.data;
        paginationButton.value = response.data.links;
        store.hideLoader();
    } catch (err) {
        console.error(err);
    }
});


const handleNext = () => {
    page.value++;
};

const handlePrev = () => {

    page.value == 1 ? 1 : page.value--;

};

const handleSearch = () => {
    page.value = 1;
    searchQueryForRequest.value = searchQuery.value;
}

const handleDelete = async (id) => {

    Swal.fire({
        title: "Do you want to delete this?",
        showCancelButton: true,
    }).then((result) => {

        if (result.isConfirmed) {
            axios.delete(`customers/${id}`).then(() => {
                
                Swal.fire("Saved!", "", "success");
                draw.value = draw.value + 1;

                //console.log(draw.value, 'draw');
            });
           
        }
    });

}


</script>
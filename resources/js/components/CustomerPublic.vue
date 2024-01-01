<template>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
            <div class="col" v-for="customer in customers" :key="customer" v-if="customers.length > 0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ customer.name }}</h5>
                        <p class="card-text">
                          <a class="text-primary"> {{ customer.email }} </a>
                           <br>
                           {{ customer.address }}
                           <br>
                           {{ customer.phone }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col" v-else>
                <h2>NO DATA</h2>
            </div>

        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { store } from '@/store';

const customers = ref([]);

onMounted(async () => {

    try {

        store.showLoader();
        let response = await axios.get('publicCustomers');
        customers.value = response.data.data;
        store.hideLoader();
    } catch (err) {
        console.log(err);
    }

});


</script>
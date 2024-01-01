<?php

namespace App\Observers;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        if($customer->visibility == 0){
            Cache::forget('publicCustomers');
        }
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        if($customer->visibility == 0){
            Cache::forget('publicCustomers');
        }
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        if($customer->visibility == 0){
            Cache::forget('publicCustomers');
        }
    }

}

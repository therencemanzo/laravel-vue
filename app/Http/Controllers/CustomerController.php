<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\PublicCustomerResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{

    //display public customer info
    public function showPublic(Request $request){


        //24 hours of caching
        return Cache::remember('publicCustomers', 60 * 60 * 24, function(){

            $customer = Customer::where('visibility', 0)->with('addedBy')->orderBy('id', 'desc')->paginate(12);
            return PublicCustomerResource::collection($customer);
        });

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $customers =  Customer::search($request->q)->orderBy('id', 'desc')->paginate(10);
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
        $customer = Auth::user()->customers()->create($request->validated());
        
        return CustomerResource::make($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //

        return CustomerResource::make($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return CustomerResource::make($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}

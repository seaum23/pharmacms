<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerResource::collection(Customer::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        try{
            return new CustomerResource(Customer::create([
                'phone' => $request->phone,
                'name' => $request->name,
                'opening_balance' => $request->opening_balance ? $request->opening_balance * 100 : 0,
                'current_balance' => $request->opening_balance ? $request->opening_balance * 100 : 0,
            ]));
        }catch(Exception $e){
            if($e->getCode() == '23000'){
                return response(['errors' => 'Phone already exists!'], 500);
            }else{
                return response($e->getMessage(), 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
        return new CustomerResource(Customer::findOrFail($customer));
        // return new CustomerResource(Customer::with('purchaseHistories.medicines')->findOrFail($customer));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

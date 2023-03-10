<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SupplierResource::collection(Supplier::all());
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
            return new SupplierResource(Supplier::create([
                'phone' => $request->phone,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'opening_balance' => $request->opening_balance ?? 0,
                'current_balance' => $request->opening_balance ?? 0,
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
     * @return \App\Http\Resources\SupplierResource
     */
    public function show($supplier)
    {
        return new SupplierResource(Supplier::findOrFail($supplier));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\SupplierResource
     */
    public function showPhone($phone)
    {
        return new SupplierResource(Supplier::where("phone", $phone)->firstOrFail());
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

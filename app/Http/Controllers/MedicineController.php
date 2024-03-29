<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return MedicineResource::collection(Medicine::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\MedicineResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'measurement' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
        ]);

        return new MedicineResource(Medicine::updateOrCreate([
            'name' => $request->name,
            'measurement' => $request->measurement,
            'unit' => $request->unit,
        ], [
            'selling_price' => $request->selling_price,
            'current_stock' => $request->old_stock ?? 0,
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\MedicineResource
     */
    public function show(Medicine $medicine)
    {
        return new MedicineResource($medicine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response|\App\Http\Resources\MedicineResource
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required',
            'measurement' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
        ]);

        $medicine->name = $request->name;
        $medicine->measurement = $request->measurement;
        $medicine->unit = $request->unit;
        $medicine->selling_price = $request->selling_price;

        if($medicine->isDirty()){
            $medicine->save();
            return new MedicineResource($medicine);
        }

        return response(204);
    }
}

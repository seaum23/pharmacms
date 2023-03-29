<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Resources\MedicineResource;

class MedicineSearchController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        return MedicineResource::collection(Medicine::where('name', 'like', "%$name%")->get());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierPurchaseHistory;

class CostController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->date){
            $date = $request->date;
        }else{
            $date = now()->format('Y-m-d');
        }
        return response()->json(SupplierPurchaseHistory::select(DB::raw("SUM(`paid_price`) as total_paid, SUM(`total_price`) as total_price"))->whereDate('created_at', $date)->first());
        // return response()->json(SupplierPurchaseHistory::select(DB::raw("SUM(`paid_price`) as total_paid, SUM(`total_price`) as total_price"))->first());
    }
}

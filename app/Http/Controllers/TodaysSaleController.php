<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedicineSaleResource;
use Illuminate\Http\Request;
use App\Models\SupplierPurchaseHistory;
use App\Http\Resources\SupplierPurchaseHistoryResource;
use App\Models\MedicineSale;

class TodaysSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if(isset($request->date)){
            $date = $request->date;
        }else{
            $date = now()->format('Y-m-d');
        }
        // return response()->json(MedicineSale::with('saleDetails', 'seller', 'customer')->whereDate('created_at', $date)->get());
        return MedicineSaleResource::collection(MedicineSale::with('saleDetails', 'seller', 'customer')->whereDate('created_at', $date)->get());        
    }
}

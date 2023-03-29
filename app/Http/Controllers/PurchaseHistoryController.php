<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierPurchaseHistory;
use App\Http\Resources\SupplierPurchaseHistoryResource;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SupplierPurchaseHistoryResource::collection(SupplierPurchaseHistory::with('supplier', 'medicines')->where('cleared', 0)->get());        
    }
}

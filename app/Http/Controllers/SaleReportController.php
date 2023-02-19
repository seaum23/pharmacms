<?php

namespace App\Http\Controllers;

use App\Models\MedicineSale;
use Illuminate\Http\Request;
use App\Http\Resources\MedicineSaleResource;

class SaleReportController extends Controller
{
    public function index()
    {
        return MedicineSaleResource::collection(MedicineSale::with('saleDetails', 'seller', 'customer')->get());                
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddStockRequest;
use App\Models\Medicine;
use App\Models\MedicineStock;
use App\Models\Supplier;
use App\Models\SupplierPurchaseHistory;
use App\Models\SupplierPurchaseMedicine;
use App\Models\TransactionHistory;
use Illuminate\Support\Arr;

class AddStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(AddStockRequest $request)
    {
        $history = DB::transaction(function () use ($request) {
            $total_price = 0;
            foreach($request->total_units as $idx => $units){
                $total_price += $units * $request->price_per_unit[$idx];
            }
            $supplier_purchase_history = SupplierPurchaseHistory::create([
                'supplier_id' => $request->supplier_id,
                'batch_id' => now(),
                'total_price' => $total_price,
                'paid_price' => $request->total_paid,
            ]);

            $purchase_medicines = [];
            foreach($request->total_units as $idx => $units){
                $purchase_medicines[] = [
                    'medicine_id' => $request->medicine_id[$idx],
                    'price_per_unit' => $request->price_per_unit[$idx] * 100,
                    'expiry' => $request->expiry[$idx],
                    'total_units' => $units,
                    'supplier_purchase_history_id' => $supplier_purchase_history->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Medicine::where('id', $request->medicine_id[$idx])->update( ['current_stock' => DB::raw( "current_stock + $units" ) ] );
            }
            SupplierPurchaseMedicine::insert($purchase_medicines);

            TransactionHistory::create([
                'type' => Supplier::class,
                'transaction_type_id' => $supplier_purchase_history->id,
                'net_amount' => $total_price,
                'paid_amount' => $request->total_paid,
            ]);

            if($total_price != $request->total_paid){
                $updated_price = ($total_price - $request->total_paid) * 100;
                Supplier::where('id', $request->supplier_id)->update(['current_balance' => DB::raw("current_balance + $updated_price")]);
            }
            return $supplier_purchase_history->id;
        });
        return response()->json(SupplierPurchaseHistory::with('medicines.medicine')->find($history));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

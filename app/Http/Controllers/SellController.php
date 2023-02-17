<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\MedicineSale;
use Illuminate\Http\Request;
use App\Models\MedicineSaleDetail;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = DB::transaction(function () use ($request) {

            $customer_id = null;
            if ($request->customer_phone) {
                $customer = Customer::firstOrCreate(
                    ['phone' => $request->customer_phone],
                    ['name' => $request->customer_name ?? NULL],
                    ['opening_balance' => 0, 'current_balance' => 0]
                );
                $customer_id = $customer->id;
            }

            // $sold_medicines_qry = Medicine::whereIn('id', $request->medicine_id);
            $sold_medicines = Medicine::whereIn('id', $request->medicine_id)->get();

            $total = 0;
            foreach($sold_medicines as $idx => $medicine){
                $quantity = $request->quantity[array_search($medicine->id, $request->medicine_id)];
                $medicine->current_stock -= $quantity;
                if($medicine->current_stock <= 0){
                    throw ValidationException::withMessages(['medicine_id[]' => $medicine->name . " " . $medicine->measurement . $medicine->unit .  ' stock is not enough!']);
                }
                $total += $quantity * $medicine->getRawOriginal('selling_price');
                $medicine->save();
            }

            // $sold_medicines->toQuery()->save();

            $total /= 100;

            $medicineSale = MedicineSale::create([
                'user_id' => auth()->id(),
                'customer_id' => $customer_id,
                'total' => $total,
                'total_paid' => $request->total_paid,
                'discount' => $request->discount,
            ]);

            $medicineSaleDetails = [];
            foreach($sold_medicines as $medicine){
                $medicineSaleDetails[] = [
                    'medicine_sale_id' => $medicineSale->id,
                    'medicine_id' => $medicine->id,
                    'price_per_unit' => $medicine->selling_price * 100,
                    'quantity' => $request->quantity[array_search($medicine->id, $request->medicine_id)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            MedicineSaleDetail::insert($medicineSaleDetails);
            // return response()->json($medicineSaleDetails);

            TransactionHistory::create([
                'type' => MedicineSaleDetail::class,
                'transaction_type_id' => $medicineSale->id,
                'net_amount' => $total,
                'paid_amount' => $request->total_paid,
                'note' => 'Selling medicine'
            ]);

            $prev_due = null;
            $returnData = ['history' => $medicineSale->id];
            if($request->customer_phone){
                $returnData['prev_due'] = $customer->current_balance;
                if($total != $request->total_paid){
                    $updated_price = $total - $request->total_paid;
                    $customer->current_balance = $customer->current_balance + $updated_price;
                    $customer->save();
                }
                $returnData['new_due'] = $customer->current_balance;
            }
            return $returnData;
        });
        // return $data;
        if($request->customer_phone){
            return response()->json(['invoice' => MedicineSale::with('saleDetails.medicine')->find($data['history']), 'prev_due' => $data['prev_due'], 'new_due' => $data['new_due']]);
        }else{
            return response()->json(['invoice' => MedicineSale::with('saleDetails.medicine')->find($data['history'])]);
        }
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

<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\MedicineSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierPurchaseHistory;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     *
     * @return \Illuminate\Http\Response
     */

    //SELECT medicine_sale_details.*, (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) as sell_price, AVG(supplier_purchase_medicines.price_per_unit) as buy_price_per_unit, (AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity) as buy_price,  ( ( AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity ) - (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) ) as profit FROM `medicine_sale_details` INNER JOIN supplier_purchase_medicines on supplier_purchase_medicines.medicine_id = medicine_sale_details.medicine_id and supplier_purchase_history_id in (SELECT supplier_purchase_histories.id from supplier_purchase_histories WHERE supplier_purchase_histories.cleared = 0) WHERE date(medicine_sale_details.created_at) = '2022-12-29' GROUP BY medicine_sale_details.id;
    public function index()
    {
        $data = [];
        // return response(now()->format("Y-m-d"));
        $todays_purchase = SupplierPurchaseHistory::select(DB::raw("SUM(`paid_price`) as total_paid, SUM(`total_price`) as total_price"))->whereDate('created_at', now()->format("Y-m-d"))->first();        
        $months_purchase = SupplierPurchaseHistory::select(DB::raw("SUM(`paid_price`) as total_paid, SUM(`total_price`) as total_price"))->whereYear('created_at', now()->format("Y"))->whereMonth('created_at', now()->format("m"))->first();
        $months_sell = MedicineSale::select(DB::raw("SUM(`total_paid`) as total_paid, SUM(`total`) as total"))->whereMonth('created_at', now()->format("m"))->first();
        $todays_sell = MedicineSale::select(DB::raw("SUM(`total_paid`) as total_paid, SUM(`total`) as total"))->whereDate('created_at', now()->format("Y-m-d"))->first();
        $total_due = Supplier::sum('current_balance') / 100;

        $daily_profit = DB::select('SELECT
        medicine_sale_details.*,
        (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) as sell_price,
        AVG(supplier_purchase_medicines.price_per_unit) as buy_price_per_unit,
        (AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity) as buy_price,
        ( ( AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity ) - (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) ) as profit
        FROM `medicine_sale_details`
        INNER JOIN supplier_purchase_medicines on
            supplier_purchase_medicines.medicine_id = medicine_sale_details.medicine_id
            and supplier_purchase_history_id in (SELECT supplier_purchase_histories.id from supplier_purchase_histories WHERE supplier_purchase_histories.cleared = 0)
        WHERE date(medicine_sale_details.created_at) = ? GROUP BY medicine_sale_details.id', [now()->format("Y-m-d")]);
        
        $daily_total_profit = 0;
        
        foreach($daily_profit as $row){
            $daily_total_profit += $row->profit;
        }

        $monthly_profit = DB::select('SELECT
        medicine_sale_details.*,
        (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) as sell_price,
        AVG(supplier_purchase_medicines.price_per_unit) as buy_price_per_unit,
        (AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity) as buy_price,
        ( ( AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity ) - (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) ) as profit
        FROM `medicine_sale_details`
        INNER JOIN supplier_purchase_medicines on
            supplier_purchase_medicines.medicine_id = medicine_sale_details.medicine_id
            and supplier_purchase_history_id in (SELECT supplier_purchase_histories.id from supplier_purchase_histories WHERE supplier_purchase_histories.cleared = 0)
        WHERE year(medicine_sale_details.created_at) = ? and month(medicine_sale_details.created_at) = ? GROUP BY medicine_sale_details.id', [now()->format("Y"),now()->format("m")]);
        
        $monthly_total_profit = 0;
        
        foreach($monthly_profit as $row){
            $monthly_total_profit += $row->profit;
        }

        $data['todays_purchase'] = $todays_purchase->total_price;
        $data['months_purchase'] = $months_purchase->total_price;
        $data['total_due'] = $total_due;
        $data['months_sale'] = $months_sell->total;
        $data['todays_sale'] = $todays_sell->total;
        $data['todays_profit'] = $daily_total_profit / 100;
        $data['months_profit'] = $monthly_total_profit / 100;
        return response($data);
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
        //
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

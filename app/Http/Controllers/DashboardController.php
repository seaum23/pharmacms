<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Customer;
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
        $total_supplier_due = Supplier::sum('current_balance') / 100;
        $total_customer_due = Customer::sum('current_balance') / 100;
        $todays_cost = Expense::select(DB::raw("SUM(`amount`) / 100 as total_amount"))->whereDate('created_at', now())->first();
        $months_cost = Expense::select(DB::raw("SUM(`amount`) / 100 as total_amount"))->whereYear('created_at', now()->format('Y'))->whereMonth('created_at', now()->format('m'))->first();

        $daily_profit = DB::select('SELECT
        medicine_sale_details.*,
        medicine_sales.discount,
        (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) as sell_price,
        AVG(supplier_purchase_medicines.price_per_unit) as buy_price_per_unit,
        (AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity) as buy_price,
        ( ( (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) - AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity ) ) as profit
        FROM `medicine_sale_details`
        INNER JOIN supplier_purchase_medicines on
            supplier_purchase_medicines.medicine_id = medicine_sale_details.medicine_id
            and supplier_purchase_history_id in (SELECT supplier_purchase_histories.id from supplier_purchase_histories WHERE supplier_purchase_histories.cleared = 0)
        INNER JOIN medicine_sales on medicine_sales.id = medicine_sale_details.medicine_sale_id
        WHERE date(medicine_sale_details.created_at) = ? GROUP BY medicine_sale_details.id', [now()->format("Y-m-d")]);
        
        $daily_total_profit = 0;
        $daily_total_discount = 0;      
        
        foreach($daily_profit as $row){
            $daily_total_discount += $row->discount;
            $daily_total_profit += $row->profit;
        }
        $daily_total_discount /= 100;      

        $monthly_profit = DB::select('SELECT
        medicine_sale_details.*,
        medicine_sales.discount,
        (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) as sell_price,
        AVG(supplier_purchase_medicines.price_per_unit) as buy_price_per_unit,
        (AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity) as buy_price,
        ( ( (medicine_sale_details.price_per_unit * medicine_sale_details.quantity) - AVG(supplier_purchase_medicines.price_per_unit) * medicine_sale_details.quantity ) ) as profit
        FROM `medicine_sale_details`
        INNER JOIN supplier_purchase_medicines on
            supplier_purchase_medicines.medicine_id = medicine_sale_details.medicine_id
            and supplier_purchase_history_id in (SELECT supplier_purchase_histories.id from supplier_purchase_histories WHERE supplier_purchase_histories.cleared = 0)
        INNER JOIN medicine_sales on medicine_sales.id = medicine_sale_details.medicine_sale_id
        WHERE year(medicine_sale_details.created_at) = ? and month(medicine_sale_details.created_at) = ? GROUP BY medicine_sale_details.id', [now()->format("Y"),now()->format("m")]);
        
        $monthly_total_profit = 0;
        $monthly_total_discount = 0;
        
        foreach($monthly_profit as $row){
            $monthly_total_discount += $row->discount;
            $monthly_total_profit += $row->profit;
        }
        $monthly_total_discount /= 100;

        $data['todays_purchase'] = $todays_purchase->total_price;
        $data['months_purchase'] = $months_purchase->total_price;
        $data['total_due'] = [
            'supplier_due' => $total_supplier_due,
            'customer_due' => $total_customer_due,
        ];
        $data['months_sale'] = $months_sell->total;
        $data['todays_sale'] = $todays_sell->total;
        $data['todays_profit'] = (($daily_total_profit - $daily_total_discount) - $todays_cost->total_amount) / 100;
        $data['months_profit'] = (($monthly_total_profit - $monthly_total_discount) - $months_cost->total_amount) / 100;
        $data['todays_cost'] = $todays_cost->total_amount / 100;
        $data['months_cost'] = $months_cost->total_amount / 100;
        $data['daily_total_discount'] = $daily_total_discount;
        $data['monthly_total_discount'] = $monthly_total_discount;
        return response($data);
    }
}

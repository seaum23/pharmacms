<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\SupplierResource;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;

class DueAdjustController extends Controller
{
    public function customerDueAdjust(Request $request, Customer $customer)
    {
        $request->validate([
            'adjust_amount' => 'required'
        ]);

        $customer->current_balance -= $request->adjust_amount;
        $customer->save();

        TransactionHistory::create([
            'type' => Customer::class,
            'transaction_type_id' => $customer->id,
            'net_amount' => $request->adjust_amount,
            'paid_amount' => $request->adjust_amount,
            'note' => 'Customer due adjust'
        ]);

        return new CustomerResource($customer);
    }

    public function supplierDueAdjust(Request $request, Supplier $supplier)
    {
        $request->validate([
            'adjust_amount' => 'required'
        ]);

        $supplier->current_balance -= $request->adjust_amount;
        $supplier->save();

        TransactionHistory::create([
            'type' => Supplier::class,
            'transaction_type_id' => $supplier->id,
            'net_amount' => $request->adjust_amount,
            'paid_amount' => $request->adjust_amount,
            'note' => 'Supplier due adjust'
        ]);

        return new SupplierResource($supplier);
    }
}

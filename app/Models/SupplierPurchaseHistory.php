<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id','batch_id','total_price','paid_price'];

    public function medicines()
    {
        return $this->hasMany(SupplierPurchaseMedicine::class);
    }
}

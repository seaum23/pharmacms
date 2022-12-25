<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id','batch_id','total_price','paid_price'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function paidPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function medicines()
    {
        return $this->hasMany(SupplierPurchaseMedicine::class);
    }
}

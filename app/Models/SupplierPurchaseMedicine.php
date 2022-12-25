<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierPurchaseMedicine extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_id','price_per_unit','expiry','total_units','supplier_purchase_history_id'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function price_per_unit(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value / 100,
    //         set: fn ($value) => $value * 100,
    //     );
    // }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

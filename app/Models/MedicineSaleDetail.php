<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineSaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_sale_id','medicine_id','price_per_unit','quantity'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function pricePerUnit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

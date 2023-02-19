<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['phone','name','img','opening_balance','current_balance'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function openingBalance(): Attribute
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
    protected function currentBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function purchaseHistories()
    {
        return $this->hasMany(MedicineSale::class);
    }    
}

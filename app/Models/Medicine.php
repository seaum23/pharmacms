<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name','measurement','unit','selling_price'];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function selling_price(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value / 100,
    //         set: fn ($value) => $value * 100,
    //     );
    // }
}

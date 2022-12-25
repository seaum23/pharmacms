<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPurchaseHistory extends Model
{
    use HasFactory;

    public function medicines()
    {
        return $this->hasMany(CustomerPurchaseMedicine::class);
    }
}

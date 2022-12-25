<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['phone','name','img','opening_balance','current_balance'];

    public function purchaseHistories()
    {
        return $this->hasMany(CustomerPurchaseHistory::class);
    }    
}

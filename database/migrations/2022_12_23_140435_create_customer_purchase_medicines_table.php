<?php

use App\Models\CustomerPurchaseHistory;
use App\Models\Medicine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_purchase_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomerPurchaseHistory::class);
            $table->foreignIdFor(Medicine::class);
            $table->integer('price_per_unit');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_purchase_medicines');
    }
};

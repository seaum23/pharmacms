<?php

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
        Schema::create('supplier_purchase_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medicine::class);
            $table->integer('price_per_unit');
            $table->integer('total_units');
            $table->date('expiry');
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
        Schema::dropIfExists('supplier_purchase_medicines');
    }
};

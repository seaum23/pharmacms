<?php

use App\Models\Medicine;
use App\Models\MedicineSale;
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
        Schema::create('medicine_sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MedicineSale::class);
            $table->foreignIdFor(Medicine::class);
            $table->integer('price_per_unit');
            $table->integer('quantity');
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
        Schema::dropIfExists('medicine_sale_details');
    }
};

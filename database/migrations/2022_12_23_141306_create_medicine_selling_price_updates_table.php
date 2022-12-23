<?php

use App\Models\Medicine;
use App\Models\User;
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
        Schema::create('medicine_selling_price_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Medicine::class);
            $table->integer('old_price');
            $table->integer('new_price');
            $table->string('reason');
            $table->foreignIdFor(User::class);
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
        Schema::dropIfExists('medicine_selling_price_updates');
    }
};

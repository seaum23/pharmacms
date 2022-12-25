<?php

use App\Models\SupplierPurchaseHistory;
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
        Schema::table('supplier_purchase_medicines', function (Blueprint $table) {
            $table->foreignIdFor(SupplierPurchaseHistory::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_purchase_medicines', function (Blueprint $table) {
            $table->dropForeignIdFor(SupplierPurchaseHistory::class);
        });
    }
};

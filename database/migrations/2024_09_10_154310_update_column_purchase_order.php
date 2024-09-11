<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('t_purchase_orders', function (Blueprint $table) {
            $table->string('total_price')->nullable();
            $table->integer('total_quantity')->nullable();
        });

        Schema::table('t_purchase_order_details', function (Blueprint $table) {
            if (Schema::hasColumn('t_purchase_order_details', 'total_price')) {
                $table->dropColumn('total_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

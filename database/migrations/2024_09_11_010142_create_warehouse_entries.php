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
        Schema::create('t_warehouse_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('t_purchase_orders');
            $table->foreignId('supplier_id')->constrained('m_suppliers');
            $table->date('arrival_date'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_warehouse_entries');
    }
};
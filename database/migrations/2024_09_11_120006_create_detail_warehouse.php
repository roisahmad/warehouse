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
        Schema::create('t_warehouse_entry_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_entry_id')->constrained('t_warehouse_entries');
            $table->foreignId('material_id')->constrained('m_materials');
            $table->integer('quantity');
            $table->enum('condition', ['good', 'bad']);
            $table->string('unique_code'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_warehouse_entry_details');
    }
};

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
        Schema::create('pemberian_pakan_sisa_pakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perhitungan_pakan_id')
                  ->constrained('perhitungan_pakan')
                  ->onDelete('cascade');
            $table->decimal('pemberian_pakan_flock_kg', 10, 2)->nullable();   
            $table->decimal('sisa_pakan_per_flock', 10, 2)->nullable();      

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_pakan_sisa_pakans');
    }
};

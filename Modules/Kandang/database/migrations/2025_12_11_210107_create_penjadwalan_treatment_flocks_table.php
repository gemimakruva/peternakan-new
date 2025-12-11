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
        Schema::create('penjadwalan_treatment_flock', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke penjadwalan_treatment
            $table->foreignId('penjadwalan_treatment_id')
                  ->constrained('penjadwalan_treatment')
                  ->onDelete('cascade');
            
            // Foreign key ke flock
            $table->foreignId('flock_id')
                  ->constrained('flock')
                  ->onDelete('cascade');
            
            // Foreign key ke jenis_treatment
            $table->foreignId('jenis_treatment_id')
                  ->constrained('jenis_treatment')
                  ->onDelete('cascade');
            
            // Foreign key ke metode_treatment
            $table->foreignId('metode_treatment_id')
                  ->constrained('metode_treatment')
                  ->onDelete('cascade');

            // Dosis pemberian treatment
            $table->string('dosis_pemberian');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjadwalan_treatment_flocks');
    }
};

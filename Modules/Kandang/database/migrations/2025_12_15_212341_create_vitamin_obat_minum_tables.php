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
        Schema::create('vitamin_obat_minum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flock_id')->constrained('flock');
            $table->foreignId('jenis_treatment_id')->constrained('jenis_treatment');
            $table->date('tanggal');
            $table->string('merk_ovk');
            $table->decimal('dosis_pemberian', 10, 3);
            $table->decimal('satuan_per_dosis', 10, 3);
            $table->decimal('air_minum_per_ekor', 10, 3);
            $table->unsignedInteger('jumlah_ayam_per_flock');
            $table->decimal('jumlah_air_di_tong_per_flock', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitamin_obat_minum');
    }
};

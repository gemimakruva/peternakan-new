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
       Schema::create('ovk_pakan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kandang_id')
            ->constrained('kandang')
            ->cascadeOnDelete();
            $table->foreignId('flock_id')
            ->constrained('flock')
            ->cascadeOnDelete();
            $table->string("merk_ovk", 100);
            $table->decimal('Dosis_OVK', 8,
             2)->nullable();
            $table->decimal('total_kebutuhan_pakan',
             10, 2)->nullable();
            $table->string('waktu_pemberian_pakan', 50)
            ->nullable();
            $table->decimal('proposi_pemberian_pagi',
             5, 2)->nullable();
            $table->decimal('proposi_pemberian_sore',
             5, 2)->nullable();
            $table->decimal('perhitungan_kebutuhan_pakan_pagi',
             10, 2)->nullable();
            $table->decimal('perhitungan_kebutuhan_pakan_sore',
             10, 2)->nullable();
            $table->decimal('perhitungan_kebutuhan_ovk',
             10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ovk_pakans');
    }
};

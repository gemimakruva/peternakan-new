<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('jenis_ovk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('satuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('standar_terkecil_satuan');
            $table->timestamps();
        });

        Schema::create('ovk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_ovk_id')->constrained('jenis_ovk');
            $table->string('nama');
            $table->decimal('dosis_pembilang');
            $table->foreignId('dosis_pembilang_satuan_id')->constrained('satuan');
            $table->decimal('dosis_penyebut');
            $table->foreignId('dosis_penyebut_satuan_id')->constrained('satuan');
            $table->decimal('penggunaan_per_hari');
            $table->foreignId('penggunaan_per_hari_satuan_id')->constrained('satuan');
            $table->decimal('harga');
            $table->decimal('harga_per_satuan');
            $table->foreignId('harga_per_satuan_id')->constrained('satuan');
            // $table->decimal('durasi_per_bulan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::drop('ovk');
        Schema::drop('satuan');
        Schema::drop('jenis_ovk');
    }
};

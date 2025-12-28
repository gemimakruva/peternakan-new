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
        Schema::create('vaksin_minum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flock_id')->constrained()->references('id')->on('flock')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('nama_vaksin');
            $table->double('total_dosis',10,3);
            $table->double('air_minum_per_ekor',10,3);
            $table->integer('jumlah_ayam_per_baris');
            $table->double('jumlah_ml_vaksin_per_baris',10,3);
            $table->double('jumlah_air_di_tong_per_baris',10,3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaksin_minum');
    }
};

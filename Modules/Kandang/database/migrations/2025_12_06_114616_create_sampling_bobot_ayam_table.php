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
        Schema::create('sampling_bobot_ayam', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('kandang_id')->constrained()->references('id')->on('kandang')->onDelete('cascade');
            $table->integer('umur');
            $table->integer('jumlah_ayam_saat_ini');
            $table->integer('jumlah_ayam_yang_disampling');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling_bobot_ayam');
    }
};

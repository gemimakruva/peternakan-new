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
        Schema::create('catatan_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_user_id')->constrained('users', 'id');
            $table->foreignId('kandang_id')->nullable()->constrained('kandang', 'id')->nullOnDelete();
            $table->integer('umur')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tipe');
            $table->text('catatan_populasi')->nullable();
            $table->text('catatan_kematian')->nullable();
            $table->text('catatan_konsumsi')->nullable();
            $table->text('catatan_produksi_telur')->nullable();
            $table->text('catatan_kpi_produksi')->nullable();
            $table->text('catatan_keseluruhan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_laporan');
    }
};

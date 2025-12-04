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
        Schema::create('produksi_telur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flock_id')->constrained('flock')->onDelete('cascade');
            $table->foreignId('pic_user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('usia_ayam');
            $table->integer('jumlah_telur_bagus');
            $table->integer('jumlah_telur_putih');
            $table->integer('jumlah_telur_reject');
            $table->decimal('berat_telur_bagus', 10, 3);
            $table->decimal('berat_telur_putih', 10, 3);
            $table->decimal('berat_telur_reject', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_telur');
    }
};

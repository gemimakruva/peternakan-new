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
        Schema::create('pengadaan_ayam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')
                  ->constrained('users', 'id')
                  ->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('kondisi_ayam');
            $table->integer('jumlah_ayam_datang');
            $table->integer('jumlah_ayam_mati');
            $table->integer('jumlah_ayam_sakit');
            $table->integer('jumlah ayam_masuk_kandang');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_ayams');
    }
};

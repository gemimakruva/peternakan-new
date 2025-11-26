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
    Schema::create('populasi_ayam', function (Blueprint $table) {
         $table->id();
        $table->foreignId('pengadaan_ayam_distribusi_id')
            ->nullable()
            ->constrained('pengadaan_ayam_distribusi')
            ->nullOnDelete();
        $table->foreignId('pic_user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
        $table->foreignId('kandang_id')
            ->nullable()
            ->constrained('kandang')
            ->nullOnDelete();
        $table->foreignId('flock_id')
            ->nullable()
            ->constrained('flock')
            ->nullOnDelete();
        $table->foreignId('pipe_id')
            ->nullable()
            ->constrained('pipe')
            ->nullOnDelete();
         $table->string('jenis_pemeriksaan')->default('harian');
        $table->date('tanggal');
        $table->integer('ayam_sehat')->default(0);
        $table->integer('ayam_sakit')->default(0);
        $table->integer('ayam_mati')->default(0);
        $table->integer('ayam_afkir')->default(0);
        $table->integer('ayam_masuk_karantina')->default(0);
        $table->integer('ayam_keluar_karantina')->default(0);
        $table->text('catatan')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('populasi_ayam');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Enums\JenisPemeriksaan;

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
            ->constrained('pengadaan_ayam_distribusi');
        $table->string('jenis_pemeriksaan')->default(JenisPemeriksaan::HARIAN);
        $table->foreignId('pic_user_id')
            ->nullable()
            ->constrained('users');
        $table->date('tanggal');
        $table->foreignId('pipe_id')
            ->nullable()
            ->constrained('pipe');
        $table->integer('umur_ayam_record');
        $table->integer('ayam_sehat')->default(0);
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

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
        Schema::create('monitoring_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tim_pelaksana');
            $table->foreignId('kandang_id')->constrained('kandang')->onDelete('cascade');
            $table->string('total_populasi_ayam');
            $table->unsignedInteger('ayam_sehat');
            $table->unsignedInteger('ayam_sakit');
            $table->unsignedInteger('ayam_mati');
            $table->unsignedInteger('ayam_afkir');
            $table->text('detail_penyakit_ditemukan')->nullable();
            $table->text('umum_perilaku')->nullable();
            $table->text('umum_kondisi_bulu')->nullable();
            $table->text('umum_proporsi_tubuh')->nullable();
            $table->text('umum_nafsu_makan')->nullable();
            $table->text('umum_produktivitas_telur')->nullable();
            $table->text('lingkungan_suhu')->nullable();
            $table->text('lingkungan_kelembapan')->nullable();
            $table->text('lingkungan_kebersihan')->nullable();
            $table->text('detail_kondisi_umum')->nullable();
            $table->unsignedInteger('nekropsi_jumlah_ayam')->nullable();
            $table->text('tindakan_pengobatan')->nullable();
            $table->text('tindakan_rekomendasi_jangka_pendek')->nullable();
            $table->text('tindakan_rekomendasi_jangka_panjang')->nullable();
            $table->text('evaluasi_efektivitas_pengobatan')->nullable();
            $table->text('evaluasi_catatan')->nullable();
            $table->json('dokumentasi')->nullable();
            $table->timestamps();

            $table->unique(['tanggal', 'kandang_id']);
        });

        Schema::create('monitoring_kesehatan_nekropsi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_kesehatan_id')->constrained('monitoring_kesehatan')->onDelete('cascade');
            $table->text('path');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_kesehatan');
        Schema::dropIfExists('monitoring_kesehatan_nekropsi');
    }
};

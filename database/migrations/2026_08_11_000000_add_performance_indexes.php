<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('populasi_ayam', function (Blueprint $table) {
            $table->index(['kandang_id', 'tanggal'], 'idx_populasi_kandang_tanggal');
            $table->index('tanggal', 'idx_populasi_tanggal');
        });

        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->index(['kandang_id', 'tanggal'], 'idx_produksi_kandang_tanggal');
        });

        Schema::table('perhitungan_pakan_item', function (Blueprint $table) {
            $table->index('perhitungan_pakan_id', 'idx_pakan_item_perhitungan');
        });

        Schema::table('pemberian_pakan_sisa_pakan', function (Blueprint $table) {
            $table->index('perhitungan_pakan_id', 'idx_sisa_pakan_perhitungan');
        });

        Schema::table('bahan_pakan_inventory', function (Blueprint $table) {
            $table->index('tanggal', 'idx_bahan_pakan_inv_tanggal');
        });

        Schema::table('telur_masuk', function (Blueprint $table) {
            $table->index('tanggal', 'idx_telur_masuk_tanggal');
        });

        Schema::table('telur_keluar', function (Blueprint $table) {
            $table->index('tanggal', 'idx_telur_keluar_tanggal');
        });

        Schema::table('karantina_populasi_pipe', function (Blueprint $table) {
            $table->index(['tanggal', 'kandang_asal_id'], 'idx_karantina_tanggal_kandang');
        });
    }

    public function down(): void
    {
        Schema::table('populasi_ayam', function (Blueprint $table) {
            $table->dropIndex('idx_populasi_kandang_tanggal');
            $table->dropIndex('idx_populasi_tanggal');
        });

        Schema::table('produksi_telur', function (Blueprint $table) {
            $table->dropIndex('idx_produksi_kandang_tanggal');
        });

        Schema::table('perhitungan_pakan_item', function (Blueprint $table) {
            $table->dropIndex('idx_pakan_item_perhitungan');
        });

        Schema::table('pemberian_pakan_sisa_pakan', function (Blueprint $table) {
            $table->dropIndex('idx_sisa_pakan_perhitungan');
        });

        Schema::table('bahan_pakan_inventory', function (Blueprint $table) {
            $table->dropIndex('idx_bahan_pakan_inv_tanggal');
        });

        Schema::table('telur_masuk', function (Blueprint $table) {
            $table->dropIndex('idx_telur_masuk_tanggal');
        });

        Schema::table('telur_keluar', function (Blueprint $table) {
            $table->dropIndex('idx_telur_keluar_tanggal');
        });

        Schema::table('karantina_populasi_pipe', function (Blueprint $table) {
            $table->dropIndex('idx_karantina_tanggal_kandang');
        });
    }
};

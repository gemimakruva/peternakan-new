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
        Schema::table('vaksin_minum', function(Blueprint $table) {
            $table->renameColumn('jumlah_ayam_per_baris', 'jumlah_ayam_per_flock');
            $table->renameColumn('jumlah_ml_vaksin_per_baris', 'jumlah_ml_vaksin_per_flock');
            $table->renameColumn('jumlah_air_di_tong_per_baris', 'jumlah_air_di_tong_per_flock');
        });

        Schema::table('vitamin_obat_minum', function(Blueprint $table) {
            $table->renameColumn('jumlah_ayam_per_baris', 'jumlah_ayam_per_flock');
            $table->renameColumn('jumlah_air_di_tong_per_baris', 'jumlah_air_di_tong_per_flock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('vitamin_obat_minum', function(Blueprint $table) {
            $table->renameColumn('jumlah_ayam_per_flock', 'jumlah_ayam_per_baris');
            $table->renameColumn('jumlah_air_di_tong_per_flock', 'jumlah_air_di_tong_per_baris');
        });

        Schema::table('vaksin_minum', function(Blueprint $table) {
            $table->renameColumn('jumlah_ayam_per_flock', 'jumlah_ayam_per_baris');
            $table->renameColumn('jumlah_ml_vaksin_per_flock', 'jumlah_ml_vaksin_per_baris');
            $table->renameColumn('jumlah_air_di_tong_per_flock', 'jumlah_air_di_tong_per_baris');
        });
    }
};

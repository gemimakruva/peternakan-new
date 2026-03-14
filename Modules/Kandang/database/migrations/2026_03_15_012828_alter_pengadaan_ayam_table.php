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
        Schema::table('pengadaan_ayam', function (Blueprint $table) {
            $table->integer('penyesuaian_hari_umur_ayam')->default(0)->after('umur_ayam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropColumns('pengadaan_ayam', 'penyesuaian_hari_umur_ayam');
    }
};

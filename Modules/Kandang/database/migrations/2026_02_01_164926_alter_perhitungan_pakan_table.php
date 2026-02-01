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
        Schema::table('perhitungan_pakan', function (Blueprint $table) {
            $table->unsignedInteger('umur_ayam')->after('tanggal_pemberian_pakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropColumns('perhitungan_pakan', 'umur_ayam');
    }
};

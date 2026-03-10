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
        Schema::table('bahan_pakan_formulasi', function (Blueprint $table) {
            $table->decimal('harga_per_kg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropColumns('bahan_pakan_formulasi', 'harga_per_kg');
    }
};

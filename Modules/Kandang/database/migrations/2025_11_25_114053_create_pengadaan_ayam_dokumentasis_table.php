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
        Schema::create('pengadaan_ayam_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_ayam_id')
            ->constrained('pengadaan_ayam')
            ->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_ayam_dokumentasis');
    }
};

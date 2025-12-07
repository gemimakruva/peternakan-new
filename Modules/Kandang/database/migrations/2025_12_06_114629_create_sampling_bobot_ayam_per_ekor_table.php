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
        Schema::create('sampling_bobot_ayam_per_ekor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sampling_bobot_ayam_id')->constrained()->references('id')->on('sampling_bobot_ayam')->onDelete('cascade');
            $table->decimal('bobot_per_kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling_bobot_ayam_per_ekor');
    }
};

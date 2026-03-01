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
        Schema::create('telur_grading', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('kandang_id')->constrained('kandang', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('telur_grading_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telur_grading_id')->constrained('telur_grading', 'id');
            $table->foreignId('telur_jenis_id')->constrained('telur_jenis', 'id');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telur_grading_item');
        Schema::dropIfExists('telur_grading');
    }
};

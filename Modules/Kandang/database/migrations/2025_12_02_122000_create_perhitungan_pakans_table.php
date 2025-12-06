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
        Schema::create('perhitungan_pakan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pemberian_pakan');
            $table->foreignId('user_creator_id')->constrained('users')->cascadeOnDelete();   
            $table->foreignId('user_executor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jenis_pakan_id')->constrained('jenis_pakan')->cascadeOnDelete();
            $table->foreignId('pipe_id')->constrained('pipe')->cascadeOnDelete();
            $table->decimal('proporsi_pemberian_pagi', 8, 2)->nullable();
            $table->decimal('proporsi_pemberian_sore', 8, 2)->nullable();
            $table->time('waktu_pemberian_pagi');
            $table->time('waktu_pemberian_sore');
            $table->integer('jumlah_ayam_per_pipe')->nullable();
            $table->decimal('jumlah_pakan_per_ekor_gram', 8, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perhitungan_pakan');
    }
};

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
        Schema::create('treatment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained('kandang');
            $table->date('tanggal');
            $table->foreignId('user_creator_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('treatment_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_id')->constrained('treatment');
            $table->foreignId('jenis_treatment_id')->constrained('jenis_treatment');
            $table->foreignId('metode_treatment_id')->constrained('metode_treatment');
            $table->string('merk_ovk');
            $table->string('area')->nullable();
            $table->string('dosis')->nullable();
            $table->time('waktu');
            $table->time('executed_at')->nullable();
            $table->foreignId('executed_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('treatment_jadwal_flock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_jadwal_id')->constrained('treatment_jadwal', 'id')->cascadeOnDelete();
            $table->foreignId('flock_id')->constrained('flock', 'id');
            $table->time('executed_at')->nullable();
            $table->foreignId('executed_by')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::drop('treatment_jadwal_flock');
        Schema::drop('treatment_jadwal');
        Schema::drop('treatment');
    }
};

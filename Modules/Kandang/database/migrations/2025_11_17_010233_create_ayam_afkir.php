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
        Schema::create('ayam_afkir', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_afkir');
            $table->unsignedBigInteger('kandang_id');
            $table->unsignedBigInteger('flock_id');
            $table->unsignedBigInteger('pipe_id');
            $table->integer('umur_ayam');
            $table->integer('jumlah_ayam_afkir');
            $table->string('penyebab_afkir')->nullable();
            $table->string('nama_pembeli');
            $table->decimal('harga_jual_per_kg', 10, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('kandang_id')
                ->references('id')
                ->on('kandang')
                ->onDelete('cascade');

            $table->foreign('flock_id')
                ->references('id')
                ->on('flock')
                ->onDelete('cascade');

            $table->foreign('pipe_id')
                ->references('id')
                ->on('pipe')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayam_afkir');
    }
};

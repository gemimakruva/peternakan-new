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
       
        Schema::create('strain_standart_metric', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel strain
            $table->unsignedBigInteger('strain_id');
            $table->foreign('strain_id')->references('id')->on('strain')->onDelete('cascade');

            // Data Standar Produksi
            $table->integer('umur');
            $table->float('berat_badan_min')->nullable(); 
            $table->float('berat_badan_max')->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('persentase_kematian')->nullable();
            $table->float('feed_intake')->nullable(); 
            $table->float('fcr')->nullable();
            $table->float('hdp')->nullable();
            $table->float('hhp')->nullable();
            $table->float('egg_weight')->nullable();
            $table->float('egg_mass')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strain_standart_metrics');
    }
};

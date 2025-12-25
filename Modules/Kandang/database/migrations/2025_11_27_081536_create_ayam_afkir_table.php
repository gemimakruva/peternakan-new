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
            $table->foreignId('populasi_ayam_id')->constrained('populasi_ayam') ;
            $table->foreignId('pic_user_id')->constrained('users');
            $table->date('tanggal');
            $table->integer('umur_ayam');
            $table->integer('jumlah_ayam_afkir');
            $table->string('penyebab_afkir')->nullable();
            $table->string('pembeli_afkir')->nullable();
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->timestamps();
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

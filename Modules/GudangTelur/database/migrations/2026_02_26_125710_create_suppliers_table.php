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
        Schema::create('satuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('kemasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('satuan_id')->constrained('satuan', 'id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('badan_usaha')->nullable();
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_kemasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('supplier', 'id');
            $table->foreignId('kemasan_id')->constrained('kemasan', 'id');
            $table->string('kode_barang');
            $table->decimal('harga')->nullable();
            $table->string('jenis_pengiriman', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_kemasan');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('kemasan');
        Schema::dropIfExists('satuan');
    }
};

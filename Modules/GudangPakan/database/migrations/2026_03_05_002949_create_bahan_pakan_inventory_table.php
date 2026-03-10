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
        Schema::create('bahan_pakan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('supplier_id')->constrained('supplier', 'id');
            $table->date('tanggal_pesan');
            $table->date('tanggal_datang')->nullable();
            $table->timestamps();
        });

        Schema::create('bahan_pakan_pembelian_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_pakan_pembelian_id')->constrained('bahan_pakan_pembelian', 'id');
            $table->foreignId('bahan_pakan_id')->constrained('bahan_pakan', 'id');
            $table->decimal('harga_satuan');
            $table->integer('jumlah');
            $table->timestamps();
        });

        Schema::create('bahan_pakan_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_pakan_pembelian_id')->nullable()->constrained('bahan_pakan_pembelian', 'id');
            $table->foreignId('supplier_id')->nullable()->constrained('supplier', 'id');
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->string('asal');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('bahan_pakan_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->string('tujuan');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('bahan_pakan_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->string('tujuan');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('bahan_pakan_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->date('tanggal');
            $table->foreignId('bahan_pakan_pembelian_item_id')->nullable()->constrained('bahan_pakan_pembelian_item', 'id')->cascadeOnDelete();
            $table->foreignId('bahan_pakan_masuk_id')->nullable()->constrained('bahan_pakan_masuk', 'id');
            $table->foreignId('bahan_pakan_keluar_id')->nullable()->constrained('bahan_pakan_keluar', 'id');
            $table->foreignId('bahan_pakan_opname_id')->nullable()->constrained('bahan_pakan_opname', 'id');
            $table->foreignId('bahan_pakan_id')->constrained('bahan_pakan', 'id');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_pakan_inventory');
        Schema::dropIfExists('bahan_pakan_opname');
        Schema::dropIfExists('bahan_pakan_keluar');
        Schema::dropIfExists('bahan_pakan_masuk');
        Schema::dropIfExists('bahan_pakan_pembelian_item');
        Schema::dropIfExists('bahan_pakan_pembelian');
    }
};

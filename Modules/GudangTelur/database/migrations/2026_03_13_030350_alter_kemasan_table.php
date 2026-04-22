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
        Schema::table('kemasan', function (Blueprint $table) {
            $table->decimal('harga')->after('nama')->nullable();
            $table->decimal('harga_satuan')->after('harga')->nullable();
        });

        Schema::dropColumns('supplier_kemasan', 'harga');

        Schema::table('kemasan_inventory', function (Blueprint $table) {
            $table->decimal('harga_satuan')->default(0)->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropColumns('kemasan', ['harga', 'harga_satuan']);

        Schema::table('supplier_kemasan', function (Blueprint $table) {
            $table->decimal('harga')->after('kode_barang');
        });

        Schema::dropColumns('kemasan_inventory', 'harga_satuan');
    }
};

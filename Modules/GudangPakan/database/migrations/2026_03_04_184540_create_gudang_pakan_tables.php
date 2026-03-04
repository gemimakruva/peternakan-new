<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bahan_pakan', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->string('nama')->unique();
            $table->timestamps();
        });

        Schema::table('supplier', function (Blueprint $table) {
            $table->string('tipe')->after('id');
        });

        Supplier::get()->map(function ($item) {
            $item->update(['tipe' => SupplierTipe::KEMASAN->value]);
        });

        Schema::create('supplier_bahan_pakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('supplier', 'id');
            $table->foreignId('bahan_pakan_id')->constrained('bahan_pakan', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('supplier_bahan_pakan');

        Schema::table('supplier', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });

        Schema::drop('bahan_pakan');
    }
};

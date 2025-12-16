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
        Schema::create('form_requets_order_ovk', function (Blueprint $table) {
          $table->id();
            $table->foreignId('kandang_id')
                  ->constrained('kandang')
                  ->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('jenis_ovk');
            $table->string('merk_ovk');
            $table->string('kemasan_ovk');
            $table->integer('total_kebutuhan_yang_diorder');
            $table->date('maksimal_kedatangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_request_order_ovks');
    }
};

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
        Schema::create('penjadwalan_treatment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')
                  ->constrained('kandang')
                  ->onDelete('cascade');
            $table->foreignId('pic_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->date('tanggal');
            $table->time('detail_waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjadwalan_treatments');
    }
};

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
        Schema::create('penjadwalan_disinfektan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained('kandang');
            $table->foreignId('pic_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal');
            $table->string('detail_waktu');
            $table->timestamps();
        });

        Schema::create('penjadwalan_disinfektan_flock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjadwalan_disinfektan_id')->constrained('penjadwalan_disinfektan', 'id', 'penjadwalan_disinfektan_id_foreign_key');
            $table->foreignId('jenis_disinfektan_id')->constrained('jenis_disinfektan');
            $table->foreignId('flock_id')->constrained('flock');
            $table->string('area');
            $table->string('merk_disinfektan');
            $table->string('dosis_per_tangki');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjadwalan_disinfektan');
        Schema::dropIfExists('penjadwalan_disinfektan_flock');
    }
};

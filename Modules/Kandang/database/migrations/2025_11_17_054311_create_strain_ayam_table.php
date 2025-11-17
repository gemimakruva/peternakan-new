<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('strain_ayam', function (Blueprint $table) {
        $table->id();
        $table->string('strain')->default('Lohmann');
        $table->integer('umur_minggu');
        $table->integer('bb_bawah');
        $table->integer('bb_atas');
        $table->integer('bb_rata2');
        $table->float('persentase_kematian')->nullable();
        $table->integer('feed_intake')->nullable();
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
        Schema::dropIfExists('strain_ayam');
    }
};

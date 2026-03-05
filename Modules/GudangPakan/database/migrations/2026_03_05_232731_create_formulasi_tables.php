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

        Schema::create('bahan_pakan_formulasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('jenis_pakan_id')->nullable()->constrained('jenis_pakan', 'id');
            $table->string('tipe');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('bahan_pakan_formulasi_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_pakan_formulasi_id')->constrained('bahan_pakan_formulasi', 'id');
            $table->foreignId('bahan_pakan_id')->constrained('bahan_pakan', 'id');
            $table->decimal('persentase');
            $table->decimal('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_pakan_formulasi_item');
        Schema::dropIfExists('bahan_pakan_formulasi');
    }
};

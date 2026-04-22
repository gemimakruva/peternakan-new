<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayam_pindah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_pic_id');
            $table->unsignedBigInteger('populasi_ayam_id');
            $table->unsignedBigInteger('asal_pipe_id');
            $table->unsignedBigInteger('tujuan_pipe_id');
            $table->integer('jumlah_perubahan');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('user_pic_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('populasi_ayam_id')->references('id')->on('populasi_ayam')->onDelete('cascade');
            $table->foreign('asal_pipe_id')->references('id')->on('pipe')->onDelete('restrict');
            $table->foreign('tujuan_pipe_id')->references('id')->on('pipe')->onDelete('restrict');

            $table->index('tanggal');
            $table->index('asal_pipe_id');
            $table->index('tujuan_pipe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayam_pindah');
    }
};

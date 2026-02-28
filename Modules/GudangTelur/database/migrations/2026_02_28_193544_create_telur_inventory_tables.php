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
        Schema::create('telur_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('tipe'); // masuk, keluar, grading
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('telur_asal', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('telur_tujuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('telur_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telur_asal_id')->constrained('telur_asal', 'id');
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('telur_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telur_tujuan_id')->constrained('telur_tujuan', 'id');
            $table->foreignId('kemasan_output_id')->constrained('kemasan_output', 'id');
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('telur_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('telur_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->foreignId('telur_masuk_id')->nullable()->constrained('telur_masuk', 'id');
            $table->foreignId('telur_keluar_id')->nullable()->constrained('telur_keluar', 'id');
            $table->foreignId('telur_opname_id')->nullable()->constrained('telur_opname', 'id');
            $table->foreignId('telur_jenis_id')->nullable()->constrained('telur_jenis', 'id');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telur_inventory');
        Schema::dropIfExists('telur_opname');
        Schema::dropIfExists('telur_keluar');
        Schema::dropIfExists('telur_masuk');
        Schema::dropIfExists('telur_tujuan');
        Schema::dropIfExists('telur_asal');
        Schema::dropIfExists('telur_jenis');
    }
};

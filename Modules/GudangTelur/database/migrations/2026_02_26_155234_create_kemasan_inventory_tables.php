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
        Schema::create('kemasan_input', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('supplier_id')->constrained('supplier', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('kemasan_input_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kemasan_input_id')->constrained('kemasan_input', 'id');
            $table->string('file_path');
            $table->timestamps();
        });

        Schema::create('kemasan_output', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('kemasan_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('kemasan_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->foreignId('supplier_id')->nullable()->constrained('supplier', 'id');
            $table->foreignId('kemasan_input_id')->nullable()->constrained('kemasan_input', 'id');
            $table->foreignId('kemasan_output_id')->nullable()->constrained('kemasan_output', 'id');
            $table->foreignId('kemasan_opname_id')->nullable()->constrained('kemasan_opname', 'id');
            $table->foreignId('kemasan_id')->nullable()->constrained('kemasan', 'id');
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
        Schema::dropIfExists('kemasan_inventory');
        Schema::dropIfExists('kemasan_opname');
        Schema::dropIfExists('kemasan_output');
        Schema::dropIfExists('kemasan_input_dokumentasi');
        Schema::dropIfExists('kemasan_input');
    }
};

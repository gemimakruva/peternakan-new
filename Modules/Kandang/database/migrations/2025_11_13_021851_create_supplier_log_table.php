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
        Schema::create('supplier_log', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('pipe_id')->constrained('pipe')->onDelete('cascade');
            $table->foreignId('flock_id')->nullable()->constrained('flock')->onDelete('set null');
            $table->foreignId('house_id')->nullable()->constrained('kandang')->onDelete('set null');

            // Informasi utama pencatatan
            $table->date('log_date')->comment('Tanggal pencatatan');
            $table->integer('bird_age')->nullable()->comment('Umur ayam dalam minggu');
            $table->string('bird_condition')->nullable()->comment('Kondisi ayam secara umum');

            // Data ayam
            $table->integer('total_chicken')->default(0)->comment('Total ayam datang');
            $table->integer('chicken_in')->default(0)->comment('Jumlah masuk kandang');
            $table->integer('died_chicken')->default(0)->comment('Ayam mati harian');
            $table->integer('culled_chicken')->default(0)->comment('Ayam afkir harian');
            $table->integer('sick_chicken')->default(0)->comment('Ayam sakit harian');

            // Dokumen & catatan
            $table->string('document_name')->nullable()->comment('Nama dokumen / berkas terkait');
            $table->string('supplier_document')->nullable()->comment('Berkas supplier (file path)');
            $table->string('documentation_photo')->nullable()->comment('Foto dokumentasi (file path)');
            $table->text('notes')->nullable()->comment('Catatan lapangan');

            // Dicatat oleh user
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_log'); // ✅ disesuaikan agar nama tabel sama
    }
};

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
        Schema::create('ayam_karantina', function (Blueprint $table) {
            $table->id();
                  $table->foreignId('populasi_ayam_id')
                  ->constrained('populasi_ayam', 'id')
                  ->cascadeOnDelete();
            $table->foreignId('pic_user_id')
                  ->nullable()
                  ->constrained('users', 'id')
                  ->nullOnDelete();
            $table->date('tanggal_karantina');
            $table->string('keterangan_pengecekan');
            $table->integer('ayam_masuk_karantina')->default(0);
            $table->integer('ayam_mati')->default(0);
            $table->integer('ayam_afkir')->default(0);
            $table->integer('ayam_keluar_karantina')->default(0);
            $table->decimal('pemberian_pakan', 8, 2)->default(0);
            $table->decimal('sisa_pakan', 8, 2)->default(0);
            $table->integer('jumlah_telur_bagus')->default(0);
            $table->integer('jumlah_telur_retak')->default(0);
            $table->integer('jumlah_telur_rusak')->default(0);
            $table->string('penyebab_karantina')->nullable();
            $table->string('pengobatan_yang_dilakukan')->nullable();
            $table->integer("jumlah_ayam_diobati")->default(0);
            $table->string('penyemprotan')->nullable();
            $table->string('vaksin')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayam_karantina');
    }
};

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
        Schema::create('karantina_populasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kandang_id')->constrained('kandang', 'id');
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            
            $table->integer('total_ayam_karantina')->default(0);
            $table->date('tanggal');
            
            $table->integer('ayam_mati')->default(0);
            $table->integer('ayam_afkir')->default(0);

            $table->decimal('pemberian_pakan', 8, 2)->default(0);
            $table->decimal('sisa_pakan', 8, 2)->default(0);

            $table->integer('jumlah_telur_bagus')->default(0);
            $table->integer('jumlah_telur_retak')->default(0);
            $table->integer('jumlah_telur_rusak')->default(0);
            
            $table->integer('berat_telur_bagus')->default(0);
            $table->integer('berat_telur_retak')->default(0);
            $table->integer('berat_telur_rusak')->default(0);

            $table->string('pengobatan_yang_dilakukan')->nullable();
            $table->integer("jumlah_ayam_diobati")->default(0);

            $table->string('penyemprotan')->nullable();
            $table->string('vaksin')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });

        Schema::create('karantina_populasi_pipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pipe_asal_id')->nullable()->constrained('pipe', 'id');
            $table->integer('ayam_masuk_karantina')->nullable();
            $table->foreignId('pipe_tujuan_id')->nullable()->constrained('pipe', 'id');
            $table->integer('ayam_keluar_karantina')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karantina_populasi_pipe');
        Schema::dropIfExists('karantina_populasi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PengadaanAyam;
use Modules\Kandang\Models\Pipe;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengadaan_ayam_distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PengadaanAyam::class, 'pengadaan_ayam_id')
                  ->constrained('pengadaan_ayam', 'id')
                  ->cascadeOnDelete();

             $table->foreignIdFor(Kandang::class, 'kandang_id')
                  ->constrained('kandang', 'id')
                  ->cascadeOnDelete();

            $table->foreignIdFor(Flock::class, 'flock_id')
                  ->constrained('flock', 'id')
                  ->cascadeOnDelete();

            $table->foreignIdFor(Pipe::class, 'pipe_id')
                  ->constrained('pipe', 'id')
                  ->cascadeOnDelete();
             $table->integer('jumlah_ayam')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_ayam_distribusi');
    }
};

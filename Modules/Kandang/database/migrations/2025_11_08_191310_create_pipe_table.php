<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Flock;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pipe', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel flock
            $table->foreignIdFor(Flock::class, 'flock_id')
                  ->constrained('flock', 'id')
                  ->cascadeOnDelete();

            // Informasi utama pipe
            $table->string('pipe_name');
            $table->unsignedInteger('capacity')->default(0);
            $table->unsignedInteger('initial_population')->default(0);

            // Tanggal dibuat & diperbarui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipe');
    }
};

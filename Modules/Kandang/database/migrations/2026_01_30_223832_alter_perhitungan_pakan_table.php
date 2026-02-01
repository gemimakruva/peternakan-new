<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Models\PerhitunganPakanItem;
use Modules\Kandang\Models\Pipe;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('perhitungan_pakan', function (Blueprint $table) {
            $table->dropForeign(['pipe_id']);
            $table->dropColumn([
                'pipe_id',
                'jumlah_ayam_per_pipe',
                'jumlah_pakan_per_ekor_gram',
            ]);
            $table->foreignIdFor(Kandang::class, 'kandang_id')->after('jenis_pakan_id')->constrained('kandang', 'id');
        });

        Schema::create('perhitungan_pakan_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PerhitunganPakan::class, 'perhitungan_pakan_id')->constrained('perhitungan_pakan', 'id');
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_id')->constrained('flock', 'id');
            $table->foreignIdFor(Pipe::class, 'pipe_id')->constrained('pipe', 'id');
            $table->date('tanggal_pemberian_pakan');
            $table->unsignedInteger('jumlah_ayam');
            $table->unsignedInteger('pemberian_pakan_per_ekor'); // gram
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        PerhitunganPakanItem::truncate();
        Schema::dropIfExists('perhitungan_pakan_item');
        PerhitunganPakan::truncate();
        Schema::table('perhitungan_pakan', function (Blueprint $table) {
            $table->dropForeign(['kandang_id']);
            $table->dropColumn('kandang_id');
            $table->foreignId('pipe_id')->after('jenis_pakan_id')->constrained('pipe');
            $table->integer('jumlah_ayam_per_pipe')->after('waktu_pemberian_sore')->nullable();
            $table->decimal('jumlah_pakan_per_ekor_gram', 8, 2)->after('jumlah_ayam_per_pipe')->nullable();
        });
    }
};

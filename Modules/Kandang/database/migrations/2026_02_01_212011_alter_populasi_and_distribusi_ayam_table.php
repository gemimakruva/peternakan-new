<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('populasi_ayam', function (Blueprint $table) {
            $table->foreignIdFor(Kandang::class, 'kandang_id')->after('tanggal')->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_id')->after('kandang_id')->constrained('flock', 'id');
        });

        Schema::table('pengadaan_ayam_distribusi', function (Blueprint $table) {
            $table->foreignIdFor(Kandang::class, 'kandang_id')->after('pengadaan_ayam_id')->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_id')->after('kandang_id')->constrained('flock', 'id');
        });

        Schema::table('karantina_populasi_pipe', function (Blueprint $table) {
            $table->foreignIdFor(Kandang::class, 'kandang_asal_id')->after('tanggal')->nullable()->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_asal_id')->after('kandang_asal_id')->nullable()->constrained('flock', 'id');
            $table->foreignIdFor(Kandang::class, 'kandang_tujuan_id')->after('ayam_masuk_karantina')->nullable()->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_tujuan_id')->after('kandang_tujuan_id')->nullable()->constrained('flock', 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karantina_populasi_pipe', function (Blueprint $table) {
            $table->dropForeign(['kandang_asal_id']);
            $table->dropForeign(['flock_asal_id']);
            $table->dropForeign(['kandang_tujuan_id']);
            $table->dropForeign(['flock_tujuan_id']);
            $table->dropColumn([
                'kandang_asal_id',
                'flock_asal_id',
                'kandang_tujuan_id',
                'flock_tujuan_id'
            ]);
        });

        Schema::table('pengadaan_ayam_distribusi', function (Blueprint $table) {
            $table->dropForeign(['kandang_id']);
            $table->dropForeign(['flock_id']);
            $table->dropColumn(['kandang_id', 'flock_id']);
        });

        Schema::table('populasi_ayam', function (Blueprint $table) {
            $table->dropForeign(['kandang_id']);
            $table->dropForeign(['flock_id']);
            $table->dropColumn(['kandang_id', 'flock_id']);
        });
    }

};

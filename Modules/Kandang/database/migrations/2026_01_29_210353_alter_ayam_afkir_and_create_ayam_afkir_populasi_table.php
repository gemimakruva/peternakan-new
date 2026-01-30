<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('ayam_afkir', function(Blueprint $table) {
            $table->dropForeign(['populasi_ayam_id']);
            $table->dropColumn('populasi_ayam_id');
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id');
            $table->dropColumn('jumlah_ayam_afkir');
            $table->foreignId('pic_user_id')->nullable(true)->change();
        });

        Schema::create('ayam_afkir_populasi', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AyamAfkir::class, 'ayam_afkir_id')->constrained('ayam_afkir', 'id');
            $table->foreignIdFor(PopulasiAyam::class, 'populasi_ayam_id')->constrained('populasi_ayam', 'id');
            $table->foreignIdFor(Pipe::class, 'pipe_id')->constrained('pipe', 'id');
            $table->foreignIdFor(Flock::class, 'flock_id')->constrained('flock', 'id');
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id');
            $table->foreignIdFor(User::class, 'pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_ayam_afkir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::drop('ayam_afkir_populasi');

        Schema::table('ayam_afkir', function(Blueprint $table) {
            $table->foreignId('pic_user_id')->nullable(false)->change();
            $table->foreignIdFor(PopulasiAyam::class, 'populasi_ayam_id')->after('id')->constrained('populasi_ayam', 'id');
            $table->dropForeign(['kandang_id']);
            $table->dropColumn('kandang_id');
            $table->unsignedInteger('jumlah_ayam_afkir')->after('umur_ayam');
        });
    }
};

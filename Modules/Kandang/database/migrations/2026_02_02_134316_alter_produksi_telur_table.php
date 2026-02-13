<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\ProduksiTelur;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::dropIfExists('produksi_telur');

        Schema::create('produksi_telur', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id');
            $table->foreignIdFor(User::class, 'pic_user_id')->constrained('users', 'id');
            $table->date('tanggal');
            $table->unsignedInteger('umur_ayam');
            $table->timestamps();
        });

        Schema::create('produksi_telur_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProduksiTelur::class, 'produksi_telur_id')->constrained('produksi_telur', 'id');
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id');
            $table->foreignIdFor(Flock::class, 'flock_id')->constrained('flock', 'id');
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_telur_bagus');
            $table->unsignedInteger('jumlah_telur_putih');
            $table->unsignedInteger('jumlah_telur_reject');
            $table->decimal('berat_telur_bagus', 10, 3);
            $table->decimal('berat_telur_putih', 10, 3);
            $table->decimal('berat_telur_reject', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('produksi_telur_item');
        Schema::dropIfExists('produksi_telur');

        Schema::create('produksi_telur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flock_id')->constrained('flock')->onDelete('cascade');
            $table->foreignId('pic_user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('usia_ayam');
            $table->integer('jumlah_telur_bagus');
            $table->integer('jumlah_telur_putih');
            $table->integer('jumlah_telur_reject');
            $table->decimal('berat_telur_bagus', 10, 3);
            $table->decimal('berat_telur_putih', 10, 3);
            $table->decimal('berat_telur_reject', 10, 3);
            $table->timestamps();
        });
    }
};

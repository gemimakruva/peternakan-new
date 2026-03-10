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
        Schema::create('pakan_pre_mixing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('formulasi_premix_id')->constrained('bahan_pakan_formulasi', 'id');
            $table->dateTime('tanggal');
            $table->decimal('jumlah_campuran');
            $table->decimal('harga_total', 15, 2);
            $table->timestamps();
        });

        Schema::create('pakan_pre_mixing_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pakan_pre_mixing_id')->constrained('pakan_pre_mixing', 'id');
            $table->foreignId('bahan_pakan_id')->constrained('bahan_pakan', 'id');
            $table->decimal('jumlah');
            $table->decimal('harga_sub_total', 15, 2);
            $table->timestamps();
        });

        Schema::create('pakan_mixing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('formulasi_mix_id')->constrained('bahan_pakan_formulasi', 'id');
            $table->dateTime('tanggal');
            $table->decimal('jumlah_campuran');
            $table->decimal('harga_total', 15, 2);
            $table->timestamps();
        });

        Schema::create('pakan_mixing_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pakan_mixing_id')->constrained('pakan_mixing', 'id');
            $table->foreignId('bahan_pakan_id')->nullable()->constrained('bahan_pakan', 'id');
            $table->foreignId('formulasi_premix_id')->nullable()->constrained('bahan_pakan_formulasi', 'id');
            $table->decimal('jumlah');
            $table->decimal('harga_sub_total', 15, 2);
            $table->timestamps();
        });

        Schema::create('pakan_pre_mixing_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pakan_pre_mixing_id')
                ->nullable()
                ->constrained('pakan_pre_mixing', 'id')
                ->cascadeOnDelete(); // masuk
            $table->foreignId('pakan_mixing_item_id')
                ->nullable()
                ->constrained('pakan_mixing_item', 'id')
                ->cascadeOnDelete();  // keluar
            $table->foreignId('formulasi_premix_id')->constrained('bahan_pakan_formulasi', 'id'); // jenis
            $table->string('tipe');
            $table->dateTime('tanggal');
            $table->decimal('jumlah');
            $table->timestamps();
        });

        Schema::create('pakan_finished_good_distribusi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->foreignId('formulasi_mix_id')->constrained('bahan_pakan_formulasi', 'id', 'pakan_distribusi_formulasi_foreign'); // jenis
            $table->dateTime('tanggal');
            $table->decimal('jumlah');
            $table->string('tujuan');
            $table->timestamps();
        });

        Schema::create('pakan_finished_good_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pakan_mixing_id')
                ->nullable()
                ->constrained('pakan_mixing', 'id')
                ->cascadeOnDelete(); // masuk
            $table->foreignId('pakan_finished_good_distribusi_id')
                ->nullable()
                ->constrained('pakan_finished_good_distribusi', 'id', 'pakan_inventory_distribusi_foreign')
                ->cascadeOnDelete(); // keluar
            $table->foreignId('formulasi_mix_id')->constrained('bahan_pakan_formulasi', 'id', 'pakan_inventory_formulasi_foreign'); // jenis
            $table->string('tipe');
            $table->dateTime('tanggal');
            $table->decimal('jumlah');
            $table->timestamps();
        });

        Schema::table('bahan_pakan_inventory', function (Blueprint $table) {
            $table->foreignId('pakan_pre_mixing_item_id')
                ->after('bahan_pakan_pembelian_item_id')
                ->nullable()
                ->constrained('pakan_pre_mixing_item', 'id')
                ->cascadeOnDelete(); // keluar
            $table->foreignId('pakan_mixing_item_id')
                ->after('pakan_pre_mixing_item_id')
                ->nullable()
                ->constrained('pakan_mixing_item', 'id')
                ->cascadeOnDelete(); // keluar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahan_pakan_inventory', function (Blueprint $table) {
            $table->dropForeign(['pakan_pre_mixing_item_id']);
            $table->dropColumn('pakan_pre_mixing_item_id');
            $table->dropForeign(['pakan_mixing_item_id']);
            $table->dropColumn('pakan_mixing_item_id');
        });
        Schema::dropIfExists('pakan_finished_good_inventory');
        Schema::dropIfExists('pakan_finished_good_distribusi');
        Schema::dropIfExists('pakan_pre_mixing_inventory');
        Schema::dropIfExists('pakan_mixing_item');
        Schema::dropIfExists('pakan_mixing');
        Schema::dropIfExists('pakan_pre_mixing_item');
        Schema::dropIfExists('pakan_pre_mixing');
    }
};

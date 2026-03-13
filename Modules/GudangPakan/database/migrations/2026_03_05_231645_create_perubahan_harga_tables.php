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
        Schema::create('perubahan_harga', function (Blueprint $table) {
            $table->id();
            $table->morphs('priceable');
            $table->foreignId('pic_user_id')->constrained('users', 'id');
            $table->decimal('harga', 15, 3);
            $table->timestamps();
        });

        Schema::table('bahan_pakan', function (Blueprint $table) {
            $table->decimal('harga', 15, 3);
            $table->decimal('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('bahan_pakan', ['harga', 'harga_satuan']);
        Schema::dropIfExists('perubahan_harga');
    }
};

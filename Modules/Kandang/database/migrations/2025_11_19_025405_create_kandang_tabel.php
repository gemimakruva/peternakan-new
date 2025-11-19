<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Strain;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kandang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignIdFor(Peternakan::class, 'peternakan_id')
             ->constrained('peternakan', 'id')
            ->cascadeOnDelete();
            $table->foreignIdFor(Strain::class, 'strain_id')
             ->constrained('strain', 'id')
            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandang');
    }
};

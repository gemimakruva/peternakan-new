<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kandang\Models\Kandang;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flock', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kandang::class, 'kandang_id')->constrained('kandang', 'id')->cascadeOnDelete();
            $table->string('flock_name', 100);
            $table->date('date_in');   
           $table->integer('capacity')->default(0);
              $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flock');
    }
};

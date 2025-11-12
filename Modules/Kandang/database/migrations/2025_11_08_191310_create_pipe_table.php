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
    $table->foreignIdFor(Flock::class, 'flock_id')
        ->constrained('flock', 'id')
        ->cascadeOnDelete();
    $table->string('pipe_name');
    $table->integer('capacity')->unsigned()->default(0);
    $table->integer('initial_population')->unsigned()->default(0);

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

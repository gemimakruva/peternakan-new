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
        Schema::create('pemberian_pakan_sisa_pakan', function (Blueprint $table) {
            $table->id();
                //   flock id
            $table->foreignId('flock_id') 
                ->constrained("flock")
                ->onDelete("cascade");
                // jenis pakan
            $table->foreignId('jenis_pakan_id')
                  ->constrained("jenis_pakan")
                  ->onDelete("cascade");
                //  user executor
            $table->foreignId('user_executor_id')
                  ->constrained("users")
                  ->onDelete("cascade");
                // tanggal
            $table->date("tanggal");

            $table->decimal('pemberian_pakan_flock_kg', 10, 2)->nullable();   
            $table->decimal('sisa_pakan_per_flock_kg', 10, 2)->nullable();      

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_pakan_sisa_pakan');
    }
};

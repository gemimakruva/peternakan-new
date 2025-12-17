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
        Schema::table('penjadwalan_disinfektan_flock', function (Blueprint $table) {
            $table->foreignId('jenis_treatment_id')->after('penjadwalan_disinfektan_id')->default(1)->constrained('jenis_treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjadwalan_disinfektan_flock', function (Blueprint $table) {
            $table->dropColumn('jenis_treatment_id');
        });
    }
};

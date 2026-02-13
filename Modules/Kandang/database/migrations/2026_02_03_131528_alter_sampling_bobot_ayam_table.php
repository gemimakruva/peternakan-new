<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('sampling_bobot_ayam', function (Blueprint $table) {
            $table->foreignId('pencatat_user_id')->after('id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('sampling_bobot_ayam', function (Blueprint $table) {
            $table->dropForeign(['pencatat_user_id']);
            $table->dropColumn('pencatat_user_id');
        });
    }
};

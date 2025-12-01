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
        Schema::table('pokemon', function (Blueprint $table) {
            $table->integer('hp')->nullable();
            $table->integer('attack')->nullable();
            $table->integer('defense')->nullable();
            $table->integer('special_attack')->nullable();
            $table->integer('special_defense')->nullable();
            $table->integer('speed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pokemon', function (Blueprint $table) {
            $table->dropColumn(['hp', 'attack', 'defense', 'special_attack', 'special_defense', 'speed']);
        });
    }
};

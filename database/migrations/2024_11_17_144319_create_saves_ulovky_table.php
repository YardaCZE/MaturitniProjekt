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
        Schema::create('saves_ulovky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ulovky_id')->constrained('ulovky')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');            $table->timestamps();

            $table->unique(['user_id', 'ulovky_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saves_ulovky');
    }
};

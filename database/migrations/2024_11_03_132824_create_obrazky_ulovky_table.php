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
        Schema::create('obrazky_ulovky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ulovku')->constrained('ulovky')->onDelete('cascade');
            $table->string('cesta_k_obrazku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obrazky_ulovky');
    }
};

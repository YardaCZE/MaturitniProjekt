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
        Schema::create('moderatori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_skupiny')->constrained('skupiny')->onDelete('cascade');
            $table->foreignId('id_uzivatele')->constrained('uzivatele')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderatori');
    }
};

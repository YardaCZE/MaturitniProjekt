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
        Schema::create('merici', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_zavodu')->constrained('zavody')->onDelete('cascade');
            $table->foreignId('id_uzivatele')->constrained('users')->onDelete('cascade');
            $table->timestamps();


            $table->unique(['id_zavodu', 'id_uzivatele']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merici');
    }
};

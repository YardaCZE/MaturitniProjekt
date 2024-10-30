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
        Schema::create('lokality', function (Blueprint $table) {
            $table->id();
            $table->string('nazev_lokality');
            $table->string('druh');
            $table->decimal('rozloha', 8, 2);
            $table->string('kraj');
            $table->string('souradnice');
            $table->foreignId('id_zakladatele')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokality');
    }
};

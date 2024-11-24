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
        Schema::create('zavody', function (Blueprint $table) {
            $table->id();
            $table->string('nazev');
            $table->foreignId('id_zakladatele')->constrained('users')->onDelete('cascade');
            $table->foreignId('lokalita')->nullable()->constrained('lokality')->onDelete('set null');
            $table->boolean('soukromost');
            $table->foreignId('stav')->constrained('stavy_zavodu')->onDelete('cascade');
            $table->timestamp('datum_zahajeni')->nullable();
            $table->timestamp('datum_ukonceni')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zavody');
    }
};

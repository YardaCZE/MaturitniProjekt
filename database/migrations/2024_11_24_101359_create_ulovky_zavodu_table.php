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
        Schema::create('ulovky_zavodu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_zavodu')->constrained('zavody')->onDelete('cascade');
            $table->foreignId('id_zavodnika')->constrained('cleni_zavodu')->onDelete('cascade');
            $table->foreignId('id_merice')->constrained('merici')->onDelete('cascade');
            $table->string('druh_ryby');
            $table->integer('delka')->nullable();
            $table->integer('vaha')->nullable();
            $table->integer('body');
            $table->timestamps();


            $table->index(['id_zavodu', 'id_zavodnika']);
            $table->index(['id_merice']);
            $table->index(['body']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulovky_zavodu');
    }
};

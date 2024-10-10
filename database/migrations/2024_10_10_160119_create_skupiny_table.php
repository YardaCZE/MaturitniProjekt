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
        Schema::create('skupiny', function (Blueprint $table) {
            $table->id();
            $table->string('nazev_skupiny');
            $table->boolean('je_soukroma')->default(false);
            $table->string('heslo')->nullable();
            $table->foreignId('id_admin')->constrained('uzivatele')->onDelete('cascade');
            $table->integer('pocet_clenu')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skupiny');
    }
};

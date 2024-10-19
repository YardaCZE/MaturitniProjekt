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

        Schema::create('prispevky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_skupiny')->constrained('skupiny')->onDelete('cascade');
            $table->foreignId('id_autora')->constrained('users');
            $table->string('nadpis');
            $table->text('text');
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prispevky');
    }
};

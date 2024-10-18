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
                $table->id('id_prispevku');
                $table->foreignId('skupina_id')->constrained('skupiny')->onDelete('cascade'); // Skupina, do které příspěvek patří
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

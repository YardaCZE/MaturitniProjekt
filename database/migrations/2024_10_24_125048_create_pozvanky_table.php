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
        Schema::create('pozvanky', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_skupiny');
            $table->string('kod_pozvanky')->unique();
            $table->integer('pocet_pouziti')->default(0);
            $table->integer('max_pocet_pouziti')->nullable();
            $table->timestamp('expirace')->nullable();
            $table->timestamps();

            $table->foreign('id_skupiny')->references('id')->on('skupiny')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pozvanky');
    }
};

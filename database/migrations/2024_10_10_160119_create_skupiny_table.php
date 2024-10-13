<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('skupiny', function (Blueprint $table) {
            $table->id();
            $table->string('nazev_skupiny');
            $table->boolean('je_soukroma')->default(0);
            $table->string('heslo')->nullable();
            $table->integer('pocet_clenu')->default(0);
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();


            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
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

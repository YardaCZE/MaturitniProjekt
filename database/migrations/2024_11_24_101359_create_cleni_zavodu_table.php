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
        Schema::create('cleni_zavodu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_zavodu')->constrained('zavody')->onDelete('cascade');
            $table->string('jmeno');
            $table->string('prijmeni');
            $table->date('datum_narozeni');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleni_zavodu');
    }
};

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

        Schema::create('ulovky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lokality')->nullable()->constrained('lokality')->onDelete('set null');
            $table->foreignId('id_uzivatele')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_druhu_reviru');
            $table->decimal('delka', 5, 2);
            $table->decimal('vaha', 5, 2)->nullable();
            $table->string('druh_ryby');
            $table->foreignId('id_typu_lovu');
            $table->boolean('soukroma')->default(false);
            $table->boolean('soukSkup')->default(false);
            $table->boolean('soukOsob')->default(false);
            $table->foreignId('soukSkupID')->nullable()->constrained('skupiny')->onDelete('set null');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulovky');
    }
};

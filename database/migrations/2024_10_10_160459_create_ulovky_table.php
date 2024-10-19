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
            $table->foreignId('id_druhu_reviru'); // Přidej cizí klíč na tabulku druhy_reviru
            $table->decimal('delka', 5, 2);
            $table->decimal('vaha', 5, 2)->nullable();
            $table->foreignId('id_obrazku')->nullable(); // Přidej cizí klíč na tabulku obrázky
            $table->foreignId('id_typu_lovu'); // Přidej cizí klíč na tabulku typy_lovu
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

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
        Schema::create('komentare_ulovky', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ulovek_id')->constrained('ulovky')->onDelete('cascade');
            $table->foreignId('uzivatel_id')->constrained('users')->onDelete('cascade');
            $table->text('text');
            $table->foreignId('parent_id')->nullable()->constrained('komentare_ulovky')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentare_ulovky');
    }
};

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
        Schema::create('komentare', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prispevek_id')->constrained('prispevky')->onDelete('cascade');
            $table->foreignId('uzivatel_id')->constrained('users')->onDelete('cascade');
            $table->text('text');
            $table->foreignId('parent_id')->nullable()->constrained('komentare')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentare');
    }
};

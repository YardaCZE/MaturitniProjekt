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
        Schema::create('kraje', function (Blueprint $table) {
            $table->id();
            $table->string('kraj');
            $table->timestamps();
        });


        DB::table('kraje')->insert([
            ['kraj' => 'Praha'],
            ['kraj' => 'Středočeský'],
            ['kraj' => 'Jihomoravský'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kraje');
    }
};

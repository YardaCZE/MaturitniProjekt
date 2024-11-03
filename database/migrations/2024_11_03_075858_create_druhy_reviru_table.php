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
        Schema::create('druhy_reviru', function (Blueprint $table) {
            $table->id();
            $table->string('druh');
            $table->timestamps();
        });


        DB::table('druhy_reviru')->insert([
            ['druh' => 'Pstruhový'],
            ['druh' => 'MimoPstruhový'],
            ['druh' => 'Soukromý'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('druhy_reviru');
    }
};

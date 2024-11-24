<?php

namespace Database\Seeders;

use App\Models\TypLovu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        DB::table('typ_lovu')->insert([
            'druh' => 'Přívlač'
        ]);

        DB::table('typ_lovu')->insert([
            'druh' => 'položená'
        ]);

        DB::table('typ_lovu')->insert([
            'druh' => 'plavaná'
        ]);

        DB::table('admins')->insert([
            'user_id' => 1
        ]);


        DB::table('stavy_zavodu')->insert([
        'stav' => "Aktivní"
         ]);

        DB::table('stavy_zavodu')->insert([
            'stav' => "Ukončený"
        ]);

        DB::table('stavy_zavodu')->insert([
            'stav' => "Nadcházející"
        ]);


    }
}

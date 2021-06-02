<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            'name' => 'Admin',
            'description' => 'Recetometro main admin.',
        ]);

        DB::table('rols')->insert([
            'name' => 'Mod',
            'description' => 'Recetometro moderators',
        ]);

        DB::table('rols')->insert([
            'name' => 'Auth',
            'description' => 'Recetometro authenticated user',
        ]);
    }
}

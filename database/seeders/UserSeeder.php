<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Iván',
            'nickname' => 'Prisy',
            'email' => 'ivancesar2000@gmail.com',
            'mailable' => '1',
            'rol_id' => '1',
            'password' => '123qwe123',
        ]);

        DB::table('users')->insert([
            'name' => 'Iván',
            'nickname' => 'Mod',
            'email' => 'moduser@recetometro.com',
            'mailable' => '1',
            'rol_id' => '2',
            'password' => '123qwe123',
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'Entrante',
            'slug' => 'entrante',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Primer plato',
            'slug' => 'primer-plato',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Guarnición',
            'slug' => 'guarnicion',
            'description' => '',
        ]);
        
        DB::table('tags')->insert([
            'name' => 'Postre',
            'slug' => 'postre',
            'description' => '',
        ]);
        
        DB::table('tags')->insert([
            'name' => 'Comida ligera',
            'slug' => 'ligera',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Bebibles',
            'slug' => 'bebibles',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Otros',
            'slug' => 'otros',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Comida rápida',
            'slug' => 'rapida',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Vegetariano',
            'slug' => 'vegetariano',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Principiantes',
            'slug' => 'principiantes',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Avanzado',
            'slug' => 'avanzado',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Aperitivos',
            'slug' => 'aperitivos',
            'description' => '',
        ]);

        DB::table('tags')->insert([
            'name' => 'Saludable',
            'slug' => 'saludable',
            'description' => '',
        ]);

    }
}

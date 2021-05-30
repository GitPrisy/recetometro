<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('means')->insert([
            'name' => 'Tradicional',
            'slug' => Str::slug('Tradicional'),
            'description' => 'Cocina tradicional',
        ]);

        DB::table('means')->insert([
            'name' => 'Thermomix',
            'slug' => Str::slug('Thermomix'),
            'description' => 'Cocina con Thermomix',
        ]);

        DB::table('means')->insert([
            'name' => 'Olla GM',
            'slug' => Str::slug('Olla GM'),
            'description' => 'Cocina con olla GM',
        ]);

        DB::table('means')->insert([
            'name' => 'Microondas',
            'slug' => Str::slug('Microondas'),
            'description' => 'Cocina con olla GM',
        ]);
    }
}

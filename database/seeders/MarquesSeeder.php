<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarquesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marques')->insert([
            'nom_marque'  => 'Adidas'
        ]);
        DB::table('marques')->insert([
            'nom_marque'  => 'Nike'
        ]);
        DB::table('marques')->insert([
            'nom_marque'  => 'Puma'
        ]);
        DB::table('marques')->insert([
            'nom_marque'  => 'New Balance'
        ]);
        DB::table('marques')->insert([
            'nom_marque'  => 'Asics'
        ]);
        DB::table('marques')->insert([
            'nom_marque'  => 'Salomon'
        ]);
        
    }
}

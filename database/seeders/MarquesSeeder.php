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
            'nom'  => 'Adidas'
        ]);
        DB::table('marques')->insert([
            'nom'  => 'Nike'
        ]);
        DB::table('marques')->insert([
            'nom'  => 'Puma'
        ]);
        DB::table('marques')->insert([
            'nom'  => 'New Balance'
        ]);
        DB::table('marques')->insert([
            'nom'  => 'Asics'
        ]);
        
    }
}

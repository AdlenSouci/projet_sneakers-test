<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TvasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tvas')->insert([
            'taux_tva'  => '20'
            
        ]);
        DB::table('tvas')->insert([
            'taux_tva'  => '19.5'
            
        ]);
        DB::table('tvas')->insert([
            'taux_tva'  => '5'
            
        ]);
        DB::table('tvas')->insert([
            'taux_tva'  => '10'
            
        ]);
    }
}

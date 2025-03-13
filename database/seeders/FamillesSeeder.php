<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamillesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('familles')->insert([
            'nom_famille'  => 'Chaussures',
            
        ]);

  
    
      

        DB::table('familles')->insert([
            'nom_famille'  => 'running',
          
        ]);

    

     
        DB::table('familles')->insert([
            'nom_famille'  => 'basket',
           
        ]);
    }
}

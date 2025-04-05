<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;   
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = array(
            array('id' => 2, 'numerique' => 12, 'alpha2' => 'DZ', 'alpha3' => 'DZA', 'nom' => 'Algeria', 'nom_gb' => 'Algeria', 'taux_tva' => 19.00),
            array('id' => 3, 'numerique' => 250, 'alpha2' => 'FR', 'alpha3' => 'FRA', 'nom' => 'France', 'nom_gb' => 'France', 'taux_tva' => 20.00),
            array('id' => 4, 'numerique' => 724, 'alpha2' => 'ES', 'alpha3' => 'ESP', 'nom' => 'Spain', 'nom_gb' => 'Spain', 'taux_tva' => 21.00),
            array('id' => 5, 'numerique' => 620, 'alpha2' => 'PT', 'alpha3' => 'PRT', 'nom' => 'Portugal', 'nom_gb' => 'Portugal', 'taux_tva' => 23.00),
            array('id' => 6, 'numerique' => 380, 'alpha2' => 'IT', 'alpha3' => 'ITA', 'nom' => 'Italy', 'nom_gb' => 'Italy', 'taux_tva' => 22.00),
            array('id' => 7, 'numerique' => 826, 'alpha2' => 'GB', 'alpha3' => 'GBR', 'nom' => 'United Kingdom', 'nom_gb' => 'United Kingdom', 'taux_tva' => 20.00),
            array('id' => 8, 'numerique' => 56, 'alpha2' => 'BE', 'alpha3' => 'BEL', 'nom' => 'Belgium', 'nom_gb' => 'Belgium', 'taux_tva' => 21.00),
            array('id' => 9, 'numerique' => 528, 'alpha2' => 'MQ', 'alpha3' => 'MTQ', 'nom' => 'Martinique', 'nom_gb' => 'Martinique', 'taux_tva' => 20.00)
            // Ajoutez d'autres pays européens ici

        );
        DB::table('pays')->insert($countries);
    }
}

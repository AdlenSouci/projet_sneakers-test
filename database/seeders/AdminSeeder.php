<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        

        User::create([
            'name' => 'Admin-Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('44-SS_qq'), // Changez le mot de passe ici
            'is_admin' => true, // Assurez-vous que vous avez un champ is_admin pour vérifier les admins
        ]);
    }
}

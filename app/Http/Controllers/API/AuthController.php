<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des données d'entrée
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Vérification si l'utilisateur existe
        $user = User::where('email', $request->email)->first();

        // Vérification des identifiants et si l'utilisateur est un admin
        if (!$user || !Hash::check($request->password, $user->password) || !$user->is_admin) {
            return response()->json(['message' => 'Email ou mot de passe incorrect ou accès non autorisé'], 401);
        }

        // Création du token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
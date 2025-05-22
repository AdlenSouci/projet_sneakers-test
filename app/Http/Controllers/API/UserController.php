<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   
    // Récupérer tous les utilisateurs
    public function index()
    {
        // Retourner la liste de tous les utilisateurs
        return response()->json(User::all());
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'adresse_livraison' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            // Vérifier si l'erreur est due à l'email déjà utilisé
            if ($validator->errors()->has('email')) {
                return response()->json(['error' => 'Un utilisateur avec cet email existe déjà.'], 409);
            }
    
            return response()->json($validator->errors(), 400);
        }

        // Créer l'utilisateur avec les données validées
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse_livraison' => $request->adresse_livraison,
            'is_admin' => $request->is_admin ?? false,  // Si is_admin n'est pas défini, on met false par défaut
        ]);

        // Retourner une réponse JSON avec l'utilisateur créé
        return response()->json($user, 201);
    }

    // Mettre à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // L'email doit être unique sauf pour l'utilisateur actuel
            'password' => 'nullable|string|min:6', // Le mot de passe est facultatif lors de la mise à jour
            'adresse_livraison' => 'nullable|string|max:255',
        ]);

        // Trouver l'utilisateur à mettre à jour
        $user = User::findOrFail($id);

        // Mettre à jour les champs de l'utilisateur
        $user->name = $request->name;
        $user->email = $request->email;
        $user->adresse_livraison = $request->adresse_livraison;

        // Si un mot de passe est fourni, on le met à jour
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Sauvegarder les modifications
        $user->save();

        // Retourner l'utilisateur mis à jour
        return response()->json($user);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        // Trouver l'utilisateur à supprimer
        $user = User::findOrFail($id);

        // Supprimer l'utilisateur
        $user->delete();

        // Retourner un message de succès
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}

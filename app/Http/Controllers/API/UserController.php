<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\ConsoleOutput;
class UserController extends Controller
{

    // Récupérer tous les utilisateurs
    public function index()
    {
        $output = new ConsoleOutput();
        $output->writeln('Récupération de tous les utilisateurs...');
        // Retourner la liste de tous les utilisateurs
        return response()->json(User::all());
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        $output = new ConsoleOutput();
        $output->writeln('Création d\'un nouvel utilisateur...');


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

        $output->writeln('Validation des données réussie.');
        // Créer l'utilisateur avec les données validées
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse_livraison' => $request->adresse_livraison,
            'is_admin' => $request->is_admin ?? false,  // Si is_admin n'est pas défini, on met false par défaut
            'telephone' => $request->telephone ?? null, // Si téléphone n'est pas défini, on le met à null
            'ville' => $request->ville ?? null, // Si ville n'est pas défini, on le met à null
            'code_postal' => $request->code_postal ?? null, // Si code postal n'est pas défini, on le met à null    
        ]);

        $output->writeln($user);
        // Retourner une réponse JSON avec l'utilisateur créé
        return response()->json($user, 201);
    }

    // Mettre à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        $output = new ConsoleOutput();
        $output->writeln('Mise à jour de l\'utilisateur avec ID: ' . $id);

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
        $user->is_admin = $request->is_admin ?? $user->is_admin; // Conserver l'état actuel si non fourni
        $user->telephone = $request->telephone ?? $user->telephone; // Conserver l'état actuel si non fourni
        $user->ville = $request->ville ?? $user->ville; // Conserver l'état actuel si non fourni
        $user->code_postal = $request->code_postal ?? $user->code_postal; // Conserver l'état actuel si non fourni

        // Si un mot de passe est fourni, on le met à jour
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $output->writeln('Mot de passe mis à jour.');
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

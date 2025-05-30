<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Annonce;
use Carbon\Carbon;
use Symfony\Component\Console\Output\ConsoleOutput;
class AnnonceController extends Controller
{



    // Récupérer toutes les annonces
    public function index()
    {
        $output = new ConsoleOutput();
        $output->writeln('Récupération de toutes les annonces...');

        $annonces = Annonce::all();
        return response()->json($annonces);
    }
    public function store(Request $request)
    {

        $output = new ConsoleOutput();
        $output->writeln('Création d\'une nouvelle annonce...');

        // $request->validate([
        //     'h1' => 'required|string|max:255',
        //     'h3' => 'required|string|max:255',
        //     'texte' => 'required|string|max:255',
        //     'imageURL' => 'required|string|max:255',
        //     'statut' => 'required|string|max:255',
        // ]);
        // $output->writeln('Validation des données réussie.');
        $output->writeln($request);

        // Création de l'annonce
        $annonce = Annonce::create([
            'h1' => $request->h1,
            'h3' => $request->h3,
            'texte' => $request->texte,
            'imageURL' => $request->imageURL,
            'statut' => $request->statut,
        ]);
        $output->writeln('Nouvelle annonce créée avec succès.');
        // Retourner une réponse JSON avec l'annonce créée
        return response()->json($annonce, 201);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'h1' => 'required|string|max:255',
            'h3' => 'required|string|max:255',
            'texte' => 'required|string|max:255',
            'imageURL' => 'required|string|max:255',
            'statut' => 'required|string|max:255',
        ]);

        // Trouver l'annonce par son ID
        $annonce = Annonce::findOrFail($id);

        $annonce->update([
            'h1' => $request->h1,
            'h3' => $request->h3,
            'texte' => $request->texte,
            'imageURL' => $request->imageURL,
            'statut' => $request->statut,
        ]);
        return response()->json($annonce);
    }

    // Supprimer une annonce
    public function destroy($id)
    {
        // Trouver la annonce par son ID
        $annonce = Annonce::findOrFail($id);

        // Supprimer l'annonce
        $annonce->delete();

        // Retourner un message de succès
        return response()->json(['message' => 'Annonce supprimée avec succès']);
    }
}

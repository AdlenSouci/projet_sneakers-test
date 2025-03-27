<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Avis;

class AvisController extends Controller
{
    public function index()
    {
        $avis = Avis::all();
        return response()->json($avis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
            'article_id' => 'required|exists:articles,id', // Assurez-vous que l'article existe
        ]);

        $avis = Avis::create([
            'contenu' => $request->contenu,
            'note' => $request->note,
            'article_id' => $request->article_id,
        ]);

        return response()->json($avis, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string',
            'note' => 'required|integer|between:1,5',
            'article_id' => 'required|exists:articles,id', // Assurez-vous que l'article existe
        ]);

        $avis = Avis::findOrFail($id);
        $avis->update([
            'contenu' => $request->contenu,
            'note' => $request->note,       

        ]);

        return response()->json($avis);
    }

    public function destroy($id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();
        return response()->json(['message' => 'Avis supprimé avec successe']);
    }
}

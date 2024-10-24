<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'contenu' => 'required|string|max:1000',
            'note' => 'required|integer|between:1,5',
        ]);

        Avis::create([
            'user_id' => auth()->id(),
            'article_id' => $request->article_id,
            'contenu' => $request->contenu,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Votre avis a été ajouté.');
    }
}

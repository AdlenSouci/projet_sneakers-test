<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ShopController extends Controller
{
/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Show the shop page.
     *
     * @return \Illuminate\View\View
     */
/******  c520be7b-d902-4a83-93de-b7a45d8794c9  *******/
    public function index(): View
    {
        $articlesData = Article::all();
        $articlesData = Article::with('avis')->get();
        return view('shop', compact('articlesData'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesData = Article::where('modele', 'like', $query . '%')->get();
        return view('shop', compact('articlesData'));
    }
}